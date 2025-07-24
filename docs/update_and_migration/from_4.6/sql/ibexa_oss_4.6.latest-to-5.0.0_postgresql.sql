-- Rename core related schema
ALTER TABLE ezbinaryfile RENAME TO ibexa_binary_file;

ALTER TABLE ezcobj_state RENAME TO ibexa_object_state;
ALTER INDEX ezcobj_state_priority RENAME TO ibexa_object_state_priority;
ALTER INDEX ezcobj_state_lmask RENAME TO ibexa_object_state_lmask;
ALTER INDEX ezcobj_state_identifier RENAME TO ibexa_object_state_identifier;

ALTER TABLE ezcobj_state_group RENAME TO ibexa_object_state_group;
ALTER INDEX ezcobj_state_group_lmask RENAME TO ibexa_object_state_group_lmask;
ALTER INDEX ezcobj_state_group_identifier RENAME TO ibexa_object_state_group_identifier;

ALTER TABLE ezcobj_state_group_language RENAME TO ibexa_object_state_group_language;

ALTER TABLE ezcobj_state_language RENAME TO ibexa_object_state_language;

ALTER TABLE ezcobj_state_link RENAME TO ibexa_object_state_link;

ALTER TABLE ezcontent_language RENAME TO ibexa_content_language;
ALTER INDEX ezcontent_language_name RENAME TO ibexa_content_language_name;

ALTER TABLE ezcontentbrowsebookmark RENAME TO ibexa_content_bookmark;
ALTER INDEX ezcontentbrowsebookmark_location RENAME TO ibexa_content_bookmark_location;
ALTER INDEX ezcontentbrowsebookmark_user RENAME TO ibexa_content_bookmark_user;
ALTER INDEX ezcontentbrowsebookmark_user_location RENAME TO ibexa_content_bookmark_user_location;

ALTER TABLE ezcontentclass RENAME TO ibexa_content_type;
ALTER INDEX ezcontentclass_version RENAME TO ibexa_content_type_version;
ALTER INDEX ezcontentclass_identifier RENAME TO ibexa_content_type_identifier;

ALTER TABLE ezcontentclass_attribute RENAME TO ibexa_content_type_field_definition;
ALTER INDEX ezcontentclass_attr_ccid RENAME TO ibexa_content_type_field_definition_ct_id;
ALTER INDEX ezcontentclass_attr_dts RENAME TO ibexa_content_type_field_definition_dts;

ALTER TABLE ezcontentclass_attribute_ml RENAME TO ibexa_content_type_field_definition_ml;
ALTER TABLE ibexa_content_type_field_definition_ml DROP CONSTRAINT ezcontentclass_attribute_ml_lang_fk;
ALTER TABLE ibexa_content_type_field_definition_ml ADD CONSTRAINT ibexa_content_type_field_definition_ml_lang_fk FOREIGN KEY (language_id) REFERENCES ibexa_content_language(id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE ezcontentclass_classgroup RENAME TO ibexa_content_type_group_assignment;

ALTER TABLE ezcontentclass_name RENAME TO ibexa_content_type_name;

ALTER TABLE ezcontentclassgroup RENAME TO ibexa_content_type_group;

ALTER TABLE ezcontentobject_tree RENAME TO ibexa_content_tree;
ALTER INDEX ezcontentobject_tree_p_node_id RENAME TO ibexa_content_tree_p_node_id;
ALTER INDEX ezcontentobject_tree_path_ident RENAME TO ibexa_content_tree_path_ident;
ALTER INDEX ezcontentobject_tree_contentobject_id_path_string RENAME TO ibexa_content_tree_contentobject_id_path_string;
ALTER INDEX ezcontentobject_tree_co_id RENAME TO ibexa_content_tree_co_id;
ALTER INDEX ezcontentobject_tree_depth RENAME TO ibexa_content_tree_depth;
ALTER INDEX ezcontentobject_tree_path RENAME TO ibexa_content_tree_path;
ALTER INDEX modified_subnode RENAME TO ibexa_content_modified_subnode;
ALTER INDEX ezcontentobject_tree_remote_id RENAME TO ibexa_content_tree_remote_id;

ALTER TABLE ibexa_content_bookmark DROP CONSTRAINT ezcontentbrowsebookmark_location_fk;
ALTER TABLE ibexa_content_bookmark ADD CONSTRAINT ibexa_content_bookmark_location_fk FOREIGN KEY (node_id) REFERENCES ibexa_content_tree(node_id) ON DELETE CASCADE;

ALTER TABLE ezcontentobject RENAME TO ibexa_content;
ALTER INDEX ezcontentobject_classid RENAME TO ibexa_content_type_id;
ALTER INDEX ezcontentobject_lmask RENAME TO ibexa_content_lmask;
ALTER INDEX ezcontentobject_pub RENAME TO ibexa_content_pub;
ALTER INDEX ezcontentobject_section RENAME TO ibexa_content_section;
ALTER INDEX ezcontentobject_currentversion RENAME TO ibexa_content_currentversion;
ALTER INDEX ezcontentobject_owner RENAME TO ibexa_content_owner;
ALTER INDEX ezcontentobject_status RENAME TO ibexa_content_status;
ALTER INDEX ezcontentobject_remote_id RENAME TO ibexa_content_remote_id;

ALTER TABLE ezcontentobject_attribute RENAME TO ibexa_content_field;
ALTER INDEX ezcontentobject_attribute_co_id_ver_lang_code RENAME TO ibexa_content_field_co_id_ver_lang_code;
ALTER INDEX ezcontentobject_classattr_id RENAME TO ibexa_content_field_classattr_id;
ALTER INDEX ezcontentobject_attribute_language_code RENAME TO ibexa_content_field_language_code;
ALTER INDEX ezcontentobject_attribute_co_id_ver RENAME TO ibexa_content_field_co_id_ver;

ALTER TABLE ezcontentobject_link RENAME TO ibexa_content_relation;
ALTER INDEX ezco_link_to_co_id RENAME TO ibexa_content_relation_to_co_id;
ALTER INDEX ezco_link_from RENAME TO ibexa_content_relation_from;
ALTER INDEX ezco_link_cca_id RENAME TO ibexa_content_relation_cca_id;

ALTER TABLE ezcontentobject_name RENAME TO ibexa_content_name;
ALTER INDEX ezcontentobject_name_lang_id RENAME TO ibexa_content_name_lang_id;
ALTER INDEX ezcontentobject_name_cov_id RENAME TO ibexa_content_name_cov_id;
ALTER INDEX ezcontentobject_name_name RENAME TO ibexa_content_name_name;

ALTER TABLE ezcontentobject_trash RENAME TO ibexa_content_trash;
ALTER INDEX ezcobj_trash_depth RENAME TO ibexa_content_trash_depth;
ALTER INDEX ezcobj_trash_p_node_id RENAME TO ibexa_content_trash_p_node_id;
ALTER INDEX ezcobj_trash_path_ident RENAME TO ibexa_content_trash_path_ident;
ALTER INDEX ezcobj_trash_co_id RENAME TO ibexa_content_trash_co_id;
ALTER INDEX ezcobj_trash_modified_subnode RENAME TO ibexa_content_trash_modified_subnode;
ALTER INDEX ezcobj_trash_path RENAME TO ibexa_content_trash_path;

ALTER TABLE ezcontentobject_version RENAME TO ibexa_content_version;
ALTER INDEX ezcobj_version_status RENAME TO ibexa_content_version_status;
ALTER INDEX idx_object_version_objver RENAME TO ibexa_content_version_idx_ver;
ALTER INDEX ezcontobj_version_obj_status RENAME TO ibexa_content_version_idx_status;
ALTER INDEX ezcobj_version_creator_id RENAME TO ibexa_content_version_creator_id;

ALTER TABLE ezdfsfile RENAME TO ibexa_dfs_file;
ALTER INDEX ezdfsfile_name_trunk RENAME TO ibexa_dfs_file_name_trunk;
ALTER INDEX ezdfsfile_expired_name RENAME TO ibexa_dfs_file_expired_name;
ALTER INDEX ezdfsfile_name RENAME TO ibexa_dfs_file_name;
ALTER INDEX ezdfsfile_mtime RENAME TO ibexa_dfs_file_mtime;

ALTER TABLE ezgmaplocation RENAME TO ibexa_map_location;
ALTER INDEX latitude_longitude_key RENAME TO ibexa_map_location_latitude_longitude_key;

ALTER TABLE ezimagefile RENAME TO ibexa_image_file;
ALTER INDEX ezimagefile_file RENAME TO ibexa_image_file_file;
ALTER INDEX ezimagefile_coid RENAME TO ibexa_image_file_coid;

ALTER TABLE ezkeyword RENAME TO ibexa_keyword;
ALTER INDEX ezkeyword_keyword RENAME TO ibexa_keyword_keyword;

ALTER TABLE ezkeyword_attribute_link RENAME TO ibexa_keyword_field_link;
ALTER INDEX ezkeyword_attr_link_oaid RENAME TO ibexa_keyword_field_link_oaid;
ALTER INDEX ezkeyword_attr_link_kid_oaid RENAME TO ibexa_keyword_field_link_kid_oaid;
ALTER INDEX ezkeyword_attr_link_oaid_ver RENAME TO ibexa_keyword_field_link_oaid_ver;

ALTER TABLE ezmedia RENAME TO ibexa_media;

ALTER TABLE eznode_assignment RENAME TO ibexa_node_assignment;
ALTER INDEX eznode_assignment_is_main RENAME TO ibexa_node_assignment_is_main;
ALTER INDEX eznode_assignment_coid_cov RENAME TO ibexa_node_assignment_coid_cov;
ALTER INDEX eznode_assignment_parent_node RENAME TO ibexa_node_assignment_parent_node;
ALTER INDEX eznode_assignment_co_version RENAME TO ibexa_node_assignment_co_version;

ALTER TABLE eznotification RENAME TO ibexa_notification;
ALTER INDEX eznotification_owner_is_pending RENAME TO ibexa_notification_owner_is_pending;
ALTER INDEX eznotification_owner RENAME TO ibexa_notification_owner;

ALTER TABLE ezpackage RENAME TO ibexa_package;

ALTER TABLE ezpolicy RENAME TO ibexa_policy;
ALTER INDEX ezpolicy_role_id RENAME TO ibexa_policy_role_id;
ALTER INDEX ezpolicy_original_id RENAME TO ibexa_policy_original_id;

ALTER TABLE ezpolicy_limitation RENAME TO ibexa_policy_limitation;
ALTER INDEX policy_id RENAME TO ibexa_policy_id;

ALTER TABLE ezpolicy_limitation_value RENAME TO ibexa_policy_limitation_value;
ALTER INDEX ezpolicy_limit_value_limit_id RENAME TO ibexa_policy_limit_value_limit_id;
ALTER INDEX ezpolicy_limitation_value_val RENAME TO ibexa_policy_limitation_value_val;

ALTER TABLE ezpreferences RENAME TO ibexa_user_preference;
ALTER INDEX ezpreferences_user_id_idx RENAME TO ibexa_user_preference_user_id_idx;
ALTER INDEX ezpreferences_name RENAME TO ibexa_user_preference_name;

ALTER TABLE ezrole RENAME TO ibexa_role;

ALTER TABLE ezsearch_object_word_link RENAME TO ibexa_search_object_word_link;
ALTER INDEX ezsearch_object_word_link_object RENAME TO ibexa_search_object_word_link_object;
ALTER INDEX ezsearch_object_word_link_identifier RENAME TO ibexa_search_object_word_link_identifier;
ALTER INDEX ezsearch_object_word_link_integer_value RENAME TO ibexa_search_object_word_link_integer_value;
ALTER INDEX ezsearch_object_word_link_word RENAME TO ibexa_search_object_word_link_word;
ALTER INDEX ezsearch_object_word_link_frequency RENAME TO ibexa_search_object_word_link_frequency;

ALTER TABLE ezsearch_word RENAME TO ibexa_search_word;
ALTER INDEX ezsearch_word_word_i RENAME TO ibexa_search_word_word_i;
ALTER INDEX ezsearch_word_obj_count RENAME TO ibexa_search_word_obj_count;

ALTER TABLE ezsection RENAME TO ibexa_section;

ALTER TABLE ezsite_data RENAME TO ibexa_site_data;

ALTER TABLE ezurl RENAME TO ibexa_url;
ALTER INDEX ezurl_url RENAME TO ibexa_url_url;

ALTER TABLE ezurl_object_link RENAME TO ibexa_url_content_link;
ALTER INDEX ezurl_ol_coa_id RENAME TO ibexa_url_ol_coa_id;
ALTER INDEX ezurl_ol_url_id RENAME TO ibexa_url_ol_url_id;
ALTER INDEX ezurl_ol_coa_version RENAME TO ibexa_url_ol_coa_version;
ALTER INDEX ezurl_ol_coa_id_cav RENAME TO ibexa_url_ol_coa_id_cav;

ALTER TABLE ezurlalias RENAME TO ibexa_url_alias;
ALTER INDEX ezurlalias_source_md5 RENAME TO ibexa_url_alias_source_md5;
ALTER INDEX ezurlalias_wcard_fwd RENAME TO ibexa_url_alias_wcard_fwd;
ALTER INDEX ezurlalias_forward_to_id RENAME TO ibexa_url_alias_forward_to_id;
ALTER INDEX ezurlalias_imp_wcard_fwd RENAME TO ibexa_url_alias_imp_wcard_fwd;
ALTER INDEX ezurlalias_source_url RENAME TO ibexa_url_alias_source_url;
ALTER INDEX ezurlalias_desturl RENAME TO ibexa_url_alias_desturl;

ALTER TABLE ezurlalias_ml RENAME TO ibexa_url_alias_ml;
ALTER INDEX ezurlalias_ml_actt_org_al RENAME TO ibexa_url_alias_ml_actt_org_al;
ALTER INDEX ezurlalias_ml_text_lang RENAME TO ibexa_url_alias_ml_text_lang;
ALTER INDEX ezurlalias_ml_par_act_id_lnk RENAME TO ibexa_url_alias_ml_par_act_id_lnk;
ALTER INDEX ezurlalias_ml_par_lnk_txt RENAME TO ibexa_url_alias_ml_par_lnk_txt;
ALTER INDEX ezurlalias_ml_act_org RENAME TO ibexa_url_alias_ml_act_org;
ALTER INDEX ezurlalias_ml_text RENAME TO ibexa_url_alias_ml_text;
ALTER INDEX ezurlalias_ml_link RENAME TO ibexa_url_alias_ml_link;
ALTER INDEX ezurlalias_ml_id RENAME TO ibexa_url_alias_ml_id;

ALTER TABLE ezurlalias_ml_incr RENAME TO ibexa_url_alias_ml_incr;

ALTER TABLE ezurlwildcard RENAME TO ibexa_url_wildcard;

ALTER TABLE ezuser RENAME TO ibexa_user;
ALTER INDEX ezuser_login RENAME TO ibexa_user_login;

ALTER TABLE ezuser_accountkey RENAME TO ibexa_user_accountkey;

ALTER TABLE ezuser_role RENAME TO ibexa_user_role;
ALTER INDEX ezuser_role_role_id RENAME TO ibexa_user_role_role_id;
ALTER INDEX ezuser_role_contentobject_id RENAME TO ibexa_user_role_contentobject_id;

ALTER TABLE ezuser_setting RENAME TO ibexa_user_setting;

ALTER TABLE ibexa_content_bookmark DROP CONSTRAINT ezcontentbrowsebookmark_user_fk;
ALTER TABLE ibexa_content_bookmark ADD CONSTRAINT ibexa_content_bookmark_user_fk FOREIGN KEY (user_id) REFERENCES ibexa_user(contentobject_id) ON DELETE CASCADE;

-- Rename contentclass_id column
ALTER TABLE ibexa_content_type_field_definition RENAME COLUMN contentclass_id TO content_type_id;
ALTER TABLE ibexa_content_type_group_assignment RENAME COLUMN contentclass_id TO content_type_id;
ALTER TABLE ibexa_content_type_name RENAME COLUMN contentclass_id TO content_type_id;
ALTER TABLE ibexa_content RENAME COLUMN contentclass_id TO content_type_id;
ALTER TABLE ibexa_search_object_word_link RENAME COLUMN contentclass_id TO content_type_id;

-- Update content type version to status
ALTER INDEX ibexa_content_type_version RENAME TO ibexa_content_type_status;
ALTER TABLE ibexa_content_type RENAME COLUMN version TO status;

ALTER TABLE ibexa_content_type_field_definition RENAME COLUMN version TO status;

ALTER TABLE ibexa_content_type_field_definition_ml RENAME COLUMN version TO status;

ALTER TABLE ibexa_content_type_group_assignment RENAME COLUMN contentclass_version TO content_type_status;
ALTER TABLE ibexa_content_type_name RENAME COLUMN contentclass_version TO content_type_status;

-- Rename user invitations tables
ALTER TABLE ibexa_user_invitations RENAME TO ibexa_user_invitation;
ALTER INDEX ibexa_user_invitations_email_idx RENAME TO ibexa_user_invitation_email_idx;
ALTER INDEX ibexa_user_invitations_hash_idx RENAME TO ibexa_user_invitation_hash_idx;
ALTER INDEX ibexa_user_invitations_email_uindex RENAME TO ibexa_user_invitation_email_uindex;
ALTER INDEX ibexa_user_invitations_hash_uindex RENAME TO ibexa_user_invitation_hash_uindex;

ALTER TABLE ibexa_user_invitations_assignments RENAME TO ibexa_user_invitation_assignment;
ALTER TABLE ibexa_user_invitation_assignment DROP CONSTRAINT ibexa_user_invitations_assignments_ibexa_user_invitations_id_fk;
ALTER TABLE ibexa_user_invitation_assignment ADD CONSTRAINT ibexa_user_invitation_assignment_ibexa_user_invitation_id_fk
    FOREIGN KEY (invitation_id) REFERENCES ibexa_user_invitation(id) ON DELETE CASCADE ON UPDATE CASCADE;

-- Rename content type field definition ML columns
ALTER TABLE ibexa_content_type_field_definition_ml RENAME COLUMN contentclass_attribute_id TO content_type_field_definition_id;

-- Rename content field columns and indexes
ALTER TABLE ibexa_content_field RENAME COLUMN contentclassattribute_id TO content_type_field_definition_id;
ALTER INDEX ibexa_content_field_classattr_id RENAME TO ibexa_content_field_field_definition_id;

-- Update content relation columns and indexes
ALTER TABLE ibexa_content_relation RENAME COLUMN contentclassattribute_id TO content_type_field_definition_id;
ALTER INDEX ibexa_content_relation_cca_id RENAME TO ibexa_content_relation_ccfd_id;

-- Update search object word link columns
ALTER TABLE ibexa_search_object_word_link RENAME COLUMN contentclass_attribute_id TO content_type_field_definition_id;

-- Rename core sequence names to match new table names
ALTER SEQUENCE ezcobj_state_group_id_seq RENAME TO ibexa_object_state_group_id_seq;
ALTER SEQUENCE ezcobj_state_id_seq RENAME TO ibexa_object_state_id_seq;
ALTER SEQUENCE ezcontentbrowsebookmark_id_seq RENAME TO ibexa_content_bookmark_id_seq;
ALTER SEQUENCE ezcontentclass_attribute_id_seq RENAME TO ibexa_content_type_field_definition_id_seq;
ALTER SEQUENCE ezcontentclass_id_seq RENAME TO ibexa_content_type_id_seq;
ALTER SEQUENCE ezcontentclassgroup_id_seq RENAME TO ibexa_content_type_group_id_seq;
ALTER SEQUENCE ezcontentobject_attribute_id_seq RENAME TO ibexa_content_field_id_seq;
ALTER SEQUENCE ezcontentobject_id_seq RENAME TO ibexa_content_id_seq;
ALTER SEQUENCE ezcontentobject_link_id_seq RENAME TO ibexa_content_relation_id_seq;
ALTER SEQUENCE ezcontentobject_tree_node_id_seq RENAME TO ibexa_content_tree_node_id_seq;
ALTER SEQUENCE ezcontentobject_version_id_seq RENAME TO ibexa_content_version_id_seq;
ALTER SEQUENCE ezimagefile_id_seq RENAME TO ibexa_image_file_id_seq;
ALTER SEQUENCE ezkeyword_attribute_link_id_seq RENAME TO ibexa_keyword_field_link_id_seq;
ALTER SEQUENCE ezkeyword_id_seq RENAME TO ibexa_keyword_id_seq;
ALTER SEQUENCE eznode_assignment_id_seq RENAME TO ibexa_node_assignment_id_seq;
ALTER SEQUENCE eznotification_id_seq RENAME TO ibexa_notification_id_seq;
ALTER SEQUENCE ezpackage_id_seq RENAME TO ibexa_package_id_seq;
ALTER SEQUENCE ezpolicy_id_seq RENAME TO ibexa_policy_id_seq;
ALTER SEQUENCE ezpolicy_limitation_id_seq RENAME TO ibexa_policy_limitation_id_seq;
ALTER SEQUENCE ezpolicy_limitation_value_id_seq RENAME TO ibexa_policy_limitation_value_id_seq;
ALTER SEQUENCE ezpreferences_id_seq RENAME TO ibexa_user_preference_id_seq;
ALTER SEQUENCE ezrole_id_seq RENAME TO ibexa_role_id_seq;
ALTER SEQUENCE ezsearch_object_word_link_id_seq RENAME TO ibexa_search_object_word_link_id_seq;
ALTER SEQUENCE ezsearch_word_id_seq RENAME TO ibexa_search_word_id_seq;
ALTER SEQUENCE ezsection_id_seq RENAME TO ibexa_section_id_seq;
ALTER SEQUENCE ezurl_id_seq RENAME TO ibexa_url_id_seq;
ALTER SEQUENCE ezurlalias_id_seq RENAME TO ibexa_url_alias_id_seq;
ALTER SEQUENCE ezurlalias_ml_incr_id_seq RENAME TO ibexa_url_alias_ml_incr_id_seq;
ALTER SEQUENCE ezurlwildcard_id_seq RENAME TO ibexa_url_wildcard_id_seq;
ALTER SEQUENCE ezuser_accountkey_id_seq RENAME TO ibexa_user_accountkey_id_seq;
ALTER SEQUENCE ezuser_role_id_seq RENAME TO ibexa_user_role_id_seq;
