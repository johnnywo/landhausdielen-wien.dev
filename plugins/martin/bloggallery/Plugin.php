<?php

    namespace Martin\BlogGallery;

    use System\Classes\PluginBase;
    use RainLab\Blog\Controllers\Posts as PostsController;
    use RainLab\Blog\Models\Post as PostModel;

    class Plugin extends PluginBase {

        public $require = ['RainLab.Blog', 'Raviraj.Rjgallery'];

        public function pluginDetails() {
            return [
                'name'        => 'martin.bloggallery::lang.plugin.name',
                'description' => 'martin.bloggallery::lang.plugin.description',
                'author'      => 'Martin M.',
                'icon'        => 'icon-image'
            ];
        }

        public function boot(){

            PostModel::extend(function ($model) {
                $model->belongsTo['rjgallery'] = ['Raviraj\Rjgallery\Models\Gallery'];
            });

            PostsController::extendFormFields(function ($form, $model) {
                if (!$model instanceof PostModel) return;
                $form->addSecondaryTabFields([
                    'rjgallery' => [
                        'label'       => 'martin.bloggallery::lang.form.label',
                        'tab'         => 'rainlab.blog::lang.post.tab_manage',
                        'type'        => 'relation',
                        'emptyOption' => 'martin.bloggallery::lang.form.empty'
                    ]
                ]);
            });

        }

    }

?>