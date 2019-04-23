<?php

namespace Encore\Admin\Console;

use Encore\Admin\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use MatthiasMullie\Minify;

class MinifyCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'admin:minify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Minify the css and js';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (!class_exists(Minify\Js::class)) {
            $this->error('To use `admin:minify` command, please install [matthiasmullie/minify] first.');
        }

        $this->initAssets();

        $this->minifyCSS();
        $this->minifyJS();

        $this->generateManifest();

        $this->comment('JS and CSS are successfully minified:');
        $this->line('  '.Admin::$min['js']);
        $this->line('  '.Admin::$min['css']);

        $this->line('');

        $this->comment('Manifest successfully generated:');
        $this->line('  '.Admin::$manifest);
    }

    protected function minifyCSS()
    {
        $css = collect(array_merge(Admin::$css, Admin::baseCss()))
            ->unique()->map(function ($css) {

                if (Str::contains($css, '?')) {
                    $css = substr($css, 0, strpos($css, '?'));
                }

                return public_path($css);
            });

        $minifier = new Minify\CSS();

        $minifier->add(...$css);

        $minifier->minify(public_path(Admin::$min['css']));
    }

    protected function minifyJS()
    {
        $js = collect(array_merge(Admin::$js, Admin::baseJs()))
            ->unique()->map(function ($js) {
                if (Str::contains($js, '?')) {
                    $js = substr($js, 0, strpos($js, '?'));
                }

                return public_path($js);
            });

        $minifier = new Minify\JS();

        $minifier->add(...$js);

        $minifier->minify(public_path(Admin::$min['js']));
    }

    protected function generateManifest()
    {
        $json = collect(Admin::$min)->flatMap(function ($value) {

            return [$value => sprintf('%s?id=%s', $value, md5(uniqid()))];

        })->toJson(JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);

        file_put_contents(public_path(Admin::$manifest), $json);
    }

    protected function initAssets()
    {
        Form::registerBuiltinFields();

        Grid::registerColumnDisplayer();

        Grid\Filter::registerFilters();

        if ($bootstrap = config('admin.bootstrap', admin_path('bootstrap.php'))) {
            require $bootstrap;
        }

        if (!empty(Admin::$booting)) {
            foreach (Admin::$booting as $callable) {
                call_user_func($callable);
            }
        }

        $assets = Form::collectFieldAssets();

        Admin::css($assets['css']);
        Admin::js($assets['js']);

        if (!empty(Admin::$booted)) {
            foreach (Admin::$booted as $callable) {
                call_user_func($callable);
            }
        }
    }
}