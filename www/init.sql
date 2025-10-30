CREATE TABLE IF NOT EXISTS subscriptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    subscription_period VARCHAR(50) NOT NULL,
    magazine VARCHAR(100) NOT NULL,
    electronic_version TINYINT(1) DEFAULT 0,
    payment_method VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);