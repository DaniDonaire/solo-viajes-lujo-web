CREATE TABLE IF NOT EXISTS svl_form_submissions (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    kind VARCHAR(20) NOT NULL,
    reference_id INT UNSIGNED NULL,
    email VARCHAR(254) NOT NULL,
    payload LONGTEXT NOT NULL,
    mail_subject VARCHAR(255) NOT NULL,
    mail_html LONGTEXT NOT NULL,
    mail_text LONGTEXT NOT NULL,
    mail_headers TEXT NOT NULL,
    mail_status VARCHAR(20) NOT NULL DEFAULT 'pending',
    mail_error TEXT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX kind_created (kind, created_at),
    INDEX email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
