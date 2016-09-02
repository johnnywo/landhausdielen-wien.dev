<?php

    namespace Martin\BlogGallery\Updates;

    use Schema;
    use October\Rain\Database\Updates\Migration;

    class CreateBlogGalleryField extends Migration {

        public function up() {
            Schema::table('rainlab_blog_posts', function ($table) {
                $table->integer('rjgallery_id')->unsigned()->nullable();
                $table->foreign('rjgallery_id')->references('id')->on('raviraj_rjgallery_galleries')->onDelete('set null');
            });
        }

        public function down() {
            if(Schema::hasColumn('rainlab_blog_posts', 'rjgallery_id')) {
                Schema::table('rainlab_blog_posts', function ($table) {
                    $table->dropForeign('rainlab_blog_posts_rjgallery_id_foreign');
                    $table->dropColumn('rjgallery_id');
                });
            }
        }

    }

?>