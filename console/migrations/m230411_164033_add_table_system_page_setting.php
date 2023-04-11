<?php

use yii\db\Migration;

/**
 * Class m230411_164033_add_table_system_page_setting
 */
class m230411_164033_add_table_system_page_setting extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `system_page_setting` (
            `id` INT NOT NULL AUTO_INCREMENT , 
            `page_key` VARCHAR(255) NOT NULL , 
            `url` VARCHAR(255) NOT NULL , 
            `meta_title` VARCHAR(255) NOT NULL , 
            `meta_keywords` VARCHAR(255) NOT NULL , 
            `meta_description` VARCHAR(255) NOT NULL , 
            `menu_name` VARCHAR(255) NOT NULL , 
            `header` VARCHAR(255) NOT NULL , 
            `text` TEXT NOT NULL , 
            `status` SMALLINT NOT NULL , 
            `position` INT NOT NULL ,
            `updated_at` INT NOT NULL , 
            PRIMARY KEY (`id`), 
            UNIQUE (`url`),
            UNIQUE (`page_key`)) ENGINE = InnoDB;");

        $this->execute("
            INSERT INTO `system_page_setting` (`id`, `page_key`, `url`, `meta_title`, `meta_keywords`, `meta_description`, `menu_name`, `header`, `text`, `status`, `position`, `updated_at`) VALUES
                (NULL, 'main', 'main', 'UBlog. Create your blog from scratch', '', '', 'Home', 'UBlog. Create your blog from scratch', '<div class=\"container-fluid py-5 text-center\">\r\n<p class=\"fs-5 fw-light\">You have successfully created your Yii-powered application.</p>\r\n            <p><a class=\"btn btn-lg btn-success\" href=\"http://www.yiiframework.com\">Get started with Yii</a></p>\r\n</div>\r\n\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n\r\n\r\n<div class=\"row\">\r\n\r\n            <div class=\"col-lg-4\">\r\n                <h2>Heading</h2>\r\n\r\n                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et\r\n                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip\r\n                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu\r\n                    fugiat nulla pariatur.</p>\r\n\r\n                <p><a class=\"btn btn-outline-secondary\" href=\"http://www.yiiframework.com/doc/\">Yii Documentation &raquo;</a></p>\r\n            </div>\r\n            <div class=\"col-lg-4\">\r\n                <h2>Heading</h2>\r\n\r\n                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et\r\n                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip\r\n                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu\r\n                    fugiat nulla pariatur.</p>\r\n\r\n                <p><a class=\"btn btn-outline-secondary\" href=\"http://www.yiiframework.com/forum/\">Yii Forum &raquo;</a></p>\r\n            </div>\r\n            <div class=\"col-lg-4\">\r\n                <h2>Heading</h2>\r\n\r\n                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et\r\n                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip\r\n                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu\r\n                    fugiat nulla pariatur.</p>\r\n\r\n                <p><a class=\"btn btn-outline-secondary\" href=\"http://www.yiiframework.com/extensions/\">Yii Extensions &raquo;</a></p>\r\n            </div>\r\n        </div>', 1, 100, 0),
                (NULL, 'blog', 'blog', 'UBlog. My Blog post list', '', '', 'Blog', 'UBlog. My Blog post list', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p><p>Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>', 1, 200, 0),
                (NULL, 'about', 'about', 'About', '', '', 'About', 'About', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>\r\n<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>', 1, 300, 0),
                (NULL, 'contact', 'contact', 'Contact', '', '', 'Contact', 'Contact', '<p>If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.\r\n</p>', 1, 400, 0),
                (NULL, '404', '404', 'Page Not Found. Error 404', '', '', 'Page Not Found. Error 404', 'Page Not Found. Error 404', '<div class=\"alert alert-danger\">Page not found.</div>\r\n\r\n<p>The above error occurred while the Web server was processing your request.</p>\r\n<p>Please contact us if you think this is a server error. Thank you.</p>', 1, 500, 0),
                (NULL, 'signup', 'signup', 'Signup', '', '', 'Signup', 'Signup', '<p>Please fill out the following fields to signup:</p>', 1, 700, 0),
                (NULL, 'login', 'login', 'Login', '', '', 'Login', 'Login', '<p>Please fill out the following fields to login:\r\n</p>', 1, 800, 0),
                (NULL, 'requestPasswordResetToken', 'request-password-reset', 'Request password reset', '', '', 'Request password reset', 'Request password reset', '<p>Please fill out your email. A link to reset password will be sent there.</p>', 1, 1000, 0),
                (NULL, 'resendVerificationEmail', 'resend-verification-email', 'Resend verification email', '', '', 'Resend verification email', 'Resend verification email', '<p>Please fill out your email. A verification email will be sent there.</p>', 1, 1100, 0),
                (NULL, 'resetPassword', 'reset-password', 'Reset password', '', '', 'Reset password', 'Reset password', '<p>Please choose your new password:</p>', 1, 1200, 0);
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('system_page_setting');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230411_164033_add_table_system_page_setting cannot be reverted.\n";

        return false;
    }
    */
}
