-- Создание администратора
-- Email: admin@example.com
-- Пароль: admin123

INSERT INTO "user" (email, roles, password) 
VALUES (
    'admin@example.com',
    '["ROLE_ADMIN"]',
    '$2y$13$pPqdyWtL07lgFZGHSkYNNeisBm1U1F2V1If33tx02hwoWybMNI6CG'
)
ON CONFLICT (email) DO NOTHING;
