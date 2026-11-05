<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. documents_lang
        if (Schema::hasTable('documents_lang')) {
            DB::statement("ALTER TABLE `documents_lang` 
                MODIFY `title` TEXT NULL,
                MODIFY `teu` TEXT NULL,
                MODIFY `subjek` TEXT NULL,
                MODIFY `pdf_name` TEXT NULL,
                MODIFY `abstract_name` TEXT NULL,
                MODIFY `unit_pemrakarsa` TEXT NULL,
                MODIFY `bidang_hukum` TEXT NULL,
                MODIFY `jenis_bentuk_peraturan` TEXT NULL,
                MODIFY `singkatan_bentuk_peraturan` TEXT NULL,
                MODIFY `edisi` TEXT NULL,
                MODIFY `jenis_peradilan` TEXT NULL,
                MODIFY `singkatan_peradilan` TEXT NULL,
                MODIFY `jangka_waktu` TEXT NULL,
                MODIFY `bahasa` TEXT NULL
            ");
        }

        // 2. news_lang
        if (Schema::hasTable('news_lang')) {
            DB::statement("ALTER TABLE `news_lang` MODIFY `title` TEXT NULL");
        }

        // 3. galleries_lang
        if (Schema::hasTable('galleries_lang')) {
            DB::statement("ALTER TABLE `galleries_lang` MODIFY `title` TEXT NULL");
        }

        // 4. infografis_lang
        if (Schema::hasTable('infografis_lang')) {
            DB::statement("ALTER TABLE `infografis_lang` MODIFY `title` TEXT NULL");
        }

        // 5. kamus_hukum_lang
        if (Schema::hasTable('kamus_hukum_lang')) {
            DB::statement("ALTER TABLE `kamus_hukum_lang` 
                MODIFY `title` TEXT NULL,
                MODIFY `intro` TEXT NULL
            ");
        }

        // 6. projects
        if (Schema::hasTable('projects')) {
            DB::statement("ALTER TABLE `projects` 
                MODIFY `name_project` TEXT NULL,
                MODIFY `applicant_name` TEXT NULL
            ");
        }

        // 7. project_update
        if (Schema::hasTable('project_update')) {
            DB::statement("ALTER TABLE `project_update` MODIFY `project_name` TEXT NULL");
        }

        // 8. menus_lang
        if (Schema::hasTable('menus_lang')) {
            DB::statement("ALTER TABLE `menus_lang` MODIFY `label` TEXT NULL");
        }

        // 9. master_documents
        if (Schema::hasTable('master_documents')) {
            DB::statement("ALTER TABLE `master_documents` MODIFY `label` TEXT NULL");
        }

        // 10. document_types
        if (Schema::hasTable('document_types')) {
            DB::statement("ALTER TABLE `document_types` MODIFY `label` TEXT NULL");
        }

        // 11. rule_types
        if (Schema::hasTable('rule_types')) {
            DB::statement("ALTER TABLE `rule_types` MODIFY `label` TEXT NULL");
        }

        // 12. rule_themes
        if (Schema::hasTable('rule_themes')) {
            DB::statement("ALTER TABLE `rule_themes` MODIFY `label` TEXT NULL");
        }

        // 13. category_project_lang
        if (Schema::hasTable('category_project_lang')) {
            DB::statement("ALTER TABLE `category_project_lang` MODIFY `label` TEXT NULL");
        }

        // 14. applicant_divisions_lang
        if (Schema::hasTable('applicant_divisions_lang')) {
            DB::statement("ALTER TABLE `applicant_divisions_lang` MODIFY `label` TEXT NULL");
        }

        // 15. status_projects_lang
        if (Schema::hasTable('status_projects_lang')) {
            DB::statement("ALTER TABLE `status_projects_lang` MODIFY `label` TEXT NULL");
        }

        // 16. public_consultation_feedbacks
        if (Schema::hasTable('public_consultation_feedbacks')) {
            DB::statement("ALTER TABLE `public_consultation_feedbacks` MODIFY `name` TEXT NULL");
        }

        // 17. ratings
        if (Schema::hasTable('ratings')) {
            DB::statement("ALTER TABLE `ratings` MODIFY `name` TEXT NULL");
        }

        // 18. contacts
        if (Schema::hasTable('contacts')) {
            DB::statement("ALTER TABLE `contacts` MODIFY `name` TEXT NULL");
        }

        // 19. accounts
        if (Schema::hasTable('accounts')) {
            DB::statement("ALTER TABLE `accounts` MODIFY `name` TEXT NULL");
        }

        // 20. permalinks
        if (Schema::hasTable('permalinks')) {
            DB::statement("ALTER TABLE `permalinks` MODIFY `label` TEXT NULL");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('documents_lang')) {
            DB::statement("ALTER TABLE `documents_lang` 
                MODIFY `title` VARCHAR(255) NULL,
                MODIFY `teu` VARCHAR(255) NULL,
                MODIFY `subjek` VARCHAR(255) NULL,
                MODIFY `pdf_name` VARCHAR(255) NULL,
                MODIFY `abstract_name` VARCHAR(255) NULL,
                MODIFY `unit_pemrakarsa` VARCHAR(255) NULL,
                MODIFY `bidang_hukum` VARCHAR(255) NULL,
                MODIFY `jenis_bentuk_peraturan` VARCHAR(255) NULL,
                MODIFY `singkatan_bentuk_peraturan` VARCHAR(255) NULL,
                MODIFY `edisi` VARCHAR(255) NULL,
                MODIFY `jenis_peradilan` VARCHAR(255) NULL,
                MODIFY `singkatan_peradilan` VARCHAR(255) NULL,
                MODIFY `jangka_waktu` VARCHAR(255) NULL,
                MODIFY `bahasa` VARCHAR(255) NULL
            ");
        }

        if (Schema::hasTable('news_lang')) {
            DB::statement("ALTER TABLE `news_lang` MODIFY `title` VARCHAR(255) NULL");
        }

        if (Schema::hasTable('galleries_lang')) {
            DB::statement("ALTER TABLE `galleries_lang` MODIFY `title` VARCHAR(255) NULL");
        }

        if (Schema::hasTable('infografis_lang')) {
            DB::statement("ALTER TABLE `infografis_lang` MODIFY `title` VARCHAR(255) NULL");
        }

        if (Schema::hasTable('kamus_hukum_lang')) {
            DB::statement("ALTER TABLE `kamus_hukum_lang` 
                MODIFY `title` VARCHAR(255) NULL,
                MODIFY `intro` VARCHAR(255) NULL
            ");
        }

        if (Schema::hasTable('projects')) {
            DB::statement("ALTER TABLE `projects` 
                MODIFY `name_project` VARCHAR(255) NULL,
                MODIFY `applicant_name` VARCHAR(255) NULL
            ");
        }

        if (Schema::hasTable('project_update')) {
            DB::statement("ALTER TABLE `project_update` MODIFY `project_name` VARCHAR(255) NULL");
        }

        if (Schema::hasTable('menus_lang')) {
            DB::statement("ALTER TABLE `menus_lang` MODIFY `label` VARCHAR(255) NULL");
        }

        if (Schema::hasTable('master_documents')) {
            DB::statement("ALTER TABLE `master_documents` MODIFY `label` VARCHAR(255) NULL");
        }

        if (Schema::hasTable('document_types')) {
            DB::statement("ALTER TABLE `document_types` MODIFY `label` VARCHAR(255) NULL");
        }

        if (Schema::hasTable('rule_types')) {
            DB::statement("ALTER TABLE `rule_types` MODIFY `label` VARCHAR(255) NULL");
        }

        if (Schema::hasTable('rule_themes')) {
            DB::statement("ALTER TABLE `rule_themes` MODIFY `label` VARCHAR(255) NULL");
        }

        if (Schema::hasTable('category_project_lang')) {
            DB::statement("ALTER TABLE `category_project_lang` MODIFY `label` VARCHAR(255) NULL");
        }

        if (Schema::hasTable('applicant_divisions_lang')) {
            DB::statement("ALTER TABLE `applicant_divisions_lang` MODIFY `label` VARCHAR(255) NULL");
        }

        if (Schema::hasTable('status_projects_lang')) {
            DB::statement("ALTER TABLE `status_projects_lang` MODIFY `label` VARCHAR(255) NULL");
        }

        if (Schema::hasTable('public_consultation_feedbacks')) {
            DB::statement("ALTER TABLE `public_consultation_feedbacks` MODIFY `name` VARCHAR(255) NULL");
        }

        if (Schema::hasTable('ratings')) {
            DB::statement("ALTER TABLE `ratings` MODIFY `name` VARCHAR(255) NULL");
        }

        if (Schema::hasTable('contacts')) {
            DB::statement("ALTER TABLE `contacts` MODIFY `name` VARCHAR(255) NULL");
        }

        if (Schema::hasTable('accounts')) {
            DB::statement("ALTER TABLE `accounts` MODIFY `name` VARCHAR(255) NULL");
        }

        if (Schema::hasTable('permalinks')) {
            DB::statement("ALTER TABLE `permalinks` MODIFY `label` VARCHAR(255) NULL");
        }
    }
};

