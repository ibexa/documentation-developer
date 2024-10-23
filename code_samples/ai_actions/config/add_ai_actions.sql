create table ibexa_action_configuration
(
    id                        int auto_increment primary key,
    identifier                varchar(64) not null,
    type                      varchar(32) not null,
    enabled                   tinyint(1)  not null,
    action_type_options       json        null,
    action_handler_options    json        null,
    action_handler_identifier varchar(64) null,
    created_at                datetime    null comment '(DC2Type:datetime_immutable)',
    updated_at                datetime    null comment '(DC2Type:datetime_immutable)',
    constraint ibexa_action_configuration_identifier_uc
        unique (identifier)
)
collate = utf8mb4_unicode_520_ci;

create index ibexa_action_configuration_enabled_idx
    on ibexa_action_configuration (enabled);

create index ibexa_action_configuration_identifier_idx
    on ibexa_action_configuration (identifier);

create table ibexa_action_configuration_ml
(
    id                      int auto_increment primary key,
    action_configuration_id int          not null,
    language_id             bigint       not null,
    name                    varchar(190) not null,
    description             longtext     null,
    constraint ibexa_action_configuration_ml_uidx
        unique (action_configuration_id, language_id),
    constraint ibexa_action_configuration_ml_to_action_configuration_fk
        foreign key (action_configuration_id) references ibexa_action_configuration (id)
            on update cascade on delete cascade,
    constraint ibexa_action_configuration_ml_to_language_fk
        foreign key (language_id) references ezcontent_language (id)
            on update cascade on delete cascade
)
    collate = utf8mb4_unicode_520_ci;

create index ibexa_action_configuration_ml_action_configuration_idx
    on ibexa_action_configuration_ml (action_configuration_id);

create index ibexa_action_configuration_ml_language_idx
    on ibexa_action_configuration_ml (language_id);