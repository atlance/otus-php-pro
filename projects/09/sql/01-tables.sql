CREATE EXTENSION IF NOT EXISTS "uuid-ossp";
-- Справочник фильмов. --
CREATE TABLE IF NOT EXISTS movies
(
    id UUID NOT NULL DEFAULT uuid_generate_v4(),
    title VARCHAR(255) NOT NULL,
    PRIMARY KEY(id)
);
COMMENT ON TABLE movies IS 'Справочник фильмов.';
COMMENT ON COLUMN movies.id IS 'Идентификатор.';
COMMENT ON COLUMN movies.title IS 'Название.';

-- Типы атрибутов. --
CREATE TABLE IF NOT EXISTS attributes_type(
    id UUID NOT NULL DEFAULT uuid_generate_v4(),
    title VARCHAR(255) NOT NULL,
    type VARCHAR(11) NOT NULL,
    PRIMARY KEY(id)
);
CREATE UNIQUE INDEX IF NOT EXISTS uniq_attributes_type_title ON attributes_type (title);
COMMENT ON TABLE attributes_type IS 'Типы атрибутов.';
COMMENT ON COLUMN attributes_type.id IS 'Идентификатор.';
COMMENT ON COLUMN attributes_type.title IS 'Название.';
COMMENT ON COLUMN attributes_type.type IS 'Тип.';

-- Атрибуты. --
CREATE TABLE IF NOT EXISTS attributes(
    id UUID NOT NULL DEFAULT uuid_generate_v4(),
    type_id UUID NOT NULL,
    title VARCHAR(255) NOT NULL,
    PRIMARY KEY(id),
    CONSTRAINT fk_attributes_type
        FOREIGN KEY(type_id)
            REFERENCES attributes_type(id)
            DEFERRABLE INITIALLY IMMEDIATE
);
COMMENT ON TABLE attributes IS 'Атрибуты.';
COMMENT ON COLUMN attributes.id IS 'Идентификатор.';
COMMENT ON COLUMN attributes.type_id IS 'Идентификатор типа атрибута.';
COMMENT ON COLUMN attributes.title IS 'Название.';

-- Атрибуты фильмов и их значения. --
CREATE TABLE IF NOT EXISTS attributes_values(
    id UUID NOT NULL DEFAULT uuid_generate_v4(),
    entity_id UUID NOT NULL,
    attribute_id UUID NOT NULL,
    value_text TEXT DEFAULT NULL,
    value_integer BIGINT DEFAULT NULL,
    value_boolean BOOLEAN DEFAULT NULL,
    value_float NUMERIC DEFAULT NULL,
    value_datetime TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
    PRIMARY KEY(id),
    CONSTRAINT fk_entity_id
        FOREIGN KEY(entity_id)
            REFERENCES movies(id) ON DELETE CASCADE
            DEFERRABLE INITIALLY IMMEDIATE,
    CONSTRAINT fk_attribute_id
        FOREIGN KEY(attribute_id)
            REFERENCES attributes(id) ON DELETE CASCADE
            DEFERRABLE INITIALLY IMMEDIATE
);
COMMENT ON TABLE attributes_values IS 'Атрибуты фильмов и их значения.';
COMMENT ON COLUMN attributes_values.id IS 'Идентификатор.';
COMMENT ON COLUMN attributes_values.entity_id IS 'Идентификатор фильма.';
COMMENT ON COLUMN attributes_values.attribute_id IS 'Идентификатор атрибута.';
COMMENT ON COLUMN attributes_values.value_text IS 'Текстовое значение.';
COMMENT ON COLUMN attributes_values.value_integer IS 'Целочисленное значение.';
COMMENT ON COLUMN attributes_values.value_boolean IS 'Логическое значение.';
COMMENT ON COLUMN attributes_values.value_float IS 'Значение с плавающей точкой.';
COMMENT ON COLUMN attributes_values.value_datetime IS 'Значение дата и время.';
-- Проверка что у нас заполнено 1 и только 1 значение. --
ALTER TABLE attributes_values
    ADD CONSTRAINT attributes_values_check_correct_value
        CHECK (
            CASE WHEN value_text IS NOT NULL THEN 1 ELSE 0 END +
            CASE WHEN value_integer IS NOT NULL THEN 1 ELSE 0 END +
            CASE WHEN value_boolean IS NOT NULL THEN 1 ELSE 0 END +
            CASE WHEN value_float IS NOT NULL THEN 1 ELSE 0 END +
            CASE WHEN value_datetime IS NOT NULL THEN 1 ELSE 0 END = 1
        );
