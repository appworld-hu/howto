@servers(['staging' => 'deployer@164.92.155.139'])

@setup
    $repository = 'git@gitlab.com:s.p.d/shop.git';
    $releasesDir = '/var/www/app/releases';
    $appDir = '/var/www/app';
    $release = date('YmdHis');
    $newReleaseDir = $releasesDir .'/'. $release;
    $currentDir = $appDir . '/current';
    $user = 'deployer';

    function logMessage($message) {
        return "echo '\033[32m" .$message. "\033[0m';\n";
    }
@endsetup

@task('rollback')
    {{ logMessage("Rolling back...") }}
    cd {{ $releasesDir }}
    ln -nfs {{ $releasesDir }}/$(find . -maxdepth 1 -name "20*" | sort  | tail -n 2 | head -n1) {{ $currentDir }}
    {{ logMessage("Rolled back!") }}

    {{ logMessage("Rebuilding cache") }}
    php {{ $currentDir }}/artisan route:cache
    php {{ $currentDir }}/artisan config:cache
    php {{ $currentDir }}/artisan view:cache
    {{ logMessage("Rebuilding cache completed") }}

    echo "Rolled back to $(find . -maxdepth 1 -name "20*" | sort  | tail -n 2 | head -n1)"
@endtask

@story('deploy')
    clone
    composer_staging
{{--    composer_production--}}
    npm_install
    npm_run
    update_symlinks
    migrate_staging
{{--    migrate_production--}}
    set_permissions
    reload_services
    cache
    clean_old_releases
@endstory

@task('clone')
    {{ logMessage("Cloning repository") }}
    git clone {{ $repository }} --branch=main --depth=1 -q {{ $newReleaseDir }}
@endtask

@task('composer_staging', ['on' => 'staging'])
    {{ logMessage("Running composer in staging") }}
    cd {{ $newReleaseDir }}
    composer install --no-interaction --quiet --prefer-dist --optimize-autoloader
@endtask

{{--@task('composer_production', ['on' => 'production'])--}}
{{--    {{ logMessage("Running composer in production") }}--}}
{{--    cd {{ $newReleaseDir }}--}}
{{--    composer install --no-interaction --quiet --no-dev --prefer-dist --optimize-autoloader--}}
{{--@endtask--}}

@task('migrate_staging', ['on' => 'staging'])
    {{ logMessage("Running migrations in staging") }}
    php {{ $newReleaseDir }}/artisan migrate:fresh --seed
@endtask

{{--@task('migrate_production', ['on' => 'production'])--}}
{{--    {{ logMessage("Running migrations in production") }}--}}
{{--    php {{ $newReleaseDir }}/artisan migrate:refresh --force--}}
{{--@endtask--}}

@task('npm_install')
    {{ logMessage("NPM install") }}
    cd {{ $newReleaseDir }}
    npm install --silent --no-progress > /dev/null
@endtask

@task('npm_run')
    {{ logMessage("NPM run") }}
    cd {{ $newReleaseDir }}
    npm run prod --silent --no-progress > /dev/null

    {{ logMessage("Deleting node_modules folder") }}
    rm -rf node_modules
@endtask

@task('update_symlinks')
    {{ logMessage("Updating symlinks") }}

    {{ logMessage("Linking storage directory") }}
    rm -rf {{ $newReleaseDir }}/storage;
    ln -nfs {{ $appDir }}/storage {{ $newReleaseDir }}/storage;
    ln -nfs {{ $appDir }}/storage/app/public {{ $newReleaseDir }}/public/storage


    {{ logMessage("Linking .env file") }}
    ln -nfs {{ $appDir }}/.env {{ $newReleaseDir }}/.env;

    {{ logMessage("Linking current release") }}
    ln -nfs {{ $newReleaseDir }} {{ $currentDir }}
@endtask

@task('set_permissions')
    {{ logMessage("Set permissions") }}

    sudo chown -R {{ $user }}:www-data {{ $appDir }}
    sudo chmod -R ug+rwx {{ $appDir }}/storage
    cd {{ $appDir }}
    sudo chown -R {{ $user }}:www-data current
    sudo chmod -R ug+rwx current/storage current/bootstrap/cache
    sudo chown -R {{ $user }}:www-data {{ $newReleaseDir }}
@endtask

@task('cache')
    {{ logMessage("Building cache") }}

    php {{ $newReleaseDir }}/artisan route:cache
    php {{ $newReleaseDir }}/artisan config:cache
    php {{ $newReleaseDir }}/artisan view:cache
@endtask

@task('clean_old_releases')
    {{ logMessage("Cleaning old releases") }}
    cd {{ $releasesDir }}
    ls -dt {{ $releasesDir }}/* | tail -n +6 | xargs -d "\n" rm -rf;
@endtask

@task('reload_services')
    {{ logMessage("Restarting service supervisor") }}
    sudo supervisorctl restart all
@endtask

@finished
    echo "Envoy deployment script finished.\r\n";
@endfinished
