CREATE TABLE tbl_agenda_agen (
  num_id_agen INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tbl_usuario_usu_num_id_usu INTEGER UNSIGNED NOT NULL,
  tbl_medico_med_num_id_med INTEGER UNSIGNED NOT NULL,
  txt_dia_agen VARCHAR(20) NULL,
  hor_inicio_agen TIME NULL,
  hor_final_agen TIME NULL,
  hor_duracaoatendimento_agen TIME NULL,
  qtd_quantidade_agen INTEGER UNSIGNED NULL,
  PRIMARY KEY(num_id_agen),
  INDEX fk_med_age(tbl_medico_med_num_id_med),
  INDEX fk_usu_age(tbl_usuario_usu_num_id_usu)
);

CREATE TABLE tbl_categoria_cat (
  num_id_cat INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  txt_nome_cat VARCHAR(50) NULL,
  num_retorno_cat INTEGER UNSIGNED NULL,
  txt_status_cat VARCHAR(3) NULL,
  PRIMARY KEY(num_id_cat)
);

CREATE TABLE tbl_cat_pro (
  num_id_cat_pro INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tbl_categoria_cat_num_id_cat INTEGER UNSIGNED NOT NULL,
  tbl_procedimentos_pro_num_id_pro INTEGER UNSIGNED NOT NULL,
  val_valor_cat_pro DOUBLE(8,2) NULL,
  txt_gerareceber_cat_pro VARCHAR(3) NULL,
  txt_ativo_cat_pro VARCHAR(3) NULL,
  PRIMARY KEY(num_id_cat_pro),
  INDEX fk_con_pro(tbl_procedimentos_pro_num_id_pro),
  INDEX fk_pro_cat(tbl_categoria_cat_num_id_cat),
  INDEX PRIMARY(num_id_cat_pro)
);

CREATE TABLE tbl_clinica_cli (
  idtbl_clinica_cli INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  txt_nome_cli VARCHAR(100) NULL,
  txt_fantasia_cli VARCHAR(100) NULL,
  txt_cnpj_cli VARCHAR(16) NULL,
  txt_endereco_cli VARCHAR(100) NULL,
  txt_telefone_cli VARCHAR(50) NULL,
  txt_site_cli VARCHAR(100) NULL,
  txt_ativo_cli CHAR(3) NULL,
  PRIMARY KEY(idtbl_clinica_cli)
);

CREATE TABLE tbl_consulta_con (
  num_id_con INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tbl_visita_vis_num_id_vis INTEGER UNSIGNED NOT NULL,
  tbl_usuario_usu_num_id_usu INTEGER UNSIGNED NOT NULL,
  txt_queixas_con TEXT NULL,
  txt_hda_con VARCHAR(100) NULL,
  txt_antecedentesfamiliares_con VARCHAR(100) NULL,
  txt_antecedentespessoais_con VARCHAR(100) NULL,
  txt_peso_con VARCHAR(10) NULL,
  txt_altura_con VARCHAR(10) NULL,
  txt_pressao_con VARCHAR(10) NULL,
  txt_batimentos_con VARCHAR(10) NULL,
  txt_diagnostico_con TEXT NULL,
  txt_outrascondutas_con VARCHAR(100) NULL,
  PRIMARY KEY(num_id_con),
  INDEX fk_age_con(tbl_visita_vis_num_id_vis),
  INDEX fk_usu_con(tbl_usuario_usu_num_id_usu)
);

CREATE TABLE tbl_contato_con (
  num_id_con INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tbl_usuario_usu_num_id_usu INTEGER UNSIGNED NOT NULL,
  tbl_paciente_pac_num_id_pac INTEGER UNSIGNED NOT NULL,
  txt_tipo_con VARCHAR(20) NULL,
  txt_observacao_con VARCHAR(200) NULL,
  txt_agendou_con CHAR(3) NULL,
  PRIMARY KEY(num_id_con),
  INDEX fk_pac_con(tbl_paciente_pac_num_id_pac),
  INDEX fk_usu_con(tbl_usuario_usu_num_id_usu)
);

CREATE TABLE tbl_especialidade_esp (
  num_id_esp INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  txt_nome_esp VARCHAR(50) NULL,
  txt_ativo_esp CHAR(3) NULL,
  PRIMARY KEY(num_id_esp)
);

CREATE TABLE tbl_exame_exa (
  num_id_exa INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  txt_dados_exa TEXT NOT NULL,
  tbl_visita_vis_num_id_vis INTEGER UNSIGNED NOT NULL,
  tbl_usuario_usu_num_id_usu INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(num_id_exa),
  INDEX fk_age_exa(tbl_visita_vis_num_id_vis),
  INDEX fk_usu_exa(tbl_usuario_usu_num_id_usu)
);

CREATE TABLE tbl_formapagamento_fp (
  num_id_fp INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  txt_nome_fp VARCHAR(20) NULL,
  txt_desricao_fp VARCHAR(200) NULL,
  txt_ativo_fp CHAR(1) NULL,
  PRIMARY KEY(num_id_fp)
);

CREATE TABLE tbl_honorarios_hon (
  num_id_hon INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tbl_usuario_usu_num_id_usu INTEGER UNSIGNED NOT NULL,
  tbl_medico_med_num_id_med INTEGER UNSIGNED NOT NULL,
  dta_inicial_hon DATE NULL,
  dta_final_hon DATE NULL,
  txt_notafiscal_hon VARCHAR(20) NULL,
  dta_pagamento_hon DATE NULL,
  val_total_hon DOUBLE(8,2) NULL,
  val_receber_hon DOUBLE(8,2) NULL,
  dth_registro_hon DATETIME NULL,
  txt_status_hon VARCHAR(20) NULL,
  PRIMARY KEY(num_id_hon),
  INDEX fk_med_hon(tbl_medico_med_num_id_med),
  INDEX fk_usu_hon(tbl_usuario_usu_num_id_usu)
);

CREATE TABLE tbl_itensreceita_itrec (
  num_id_itrec INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tbl_medicamentos_medi_num_id_medi INTEGER UNSIGNED NOT NULL,
  tbl_receita_rec_num_id_rec INTEGER UNSIGNED NOT NULL,
  txt_observacoes_itrec VARCHAR(100) NULL,
  PRIMARY KEY(num_id_itrec),
  INDEX fk_rec_itrec(tbl_receita_rec_num_id_rec),
  INDEX fk_medi_itrec(tbl_medicamentos_medi_num_id_medi)
);

CREATE TABLE tbl_laudo_lau (
  num_id_lau INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tbl_usuario_usu_num_id_usu INTEGER UNSIGNED NOT NULL,
  tbl_medico_med_num_id_med INTEGER UNSIGNED NOT NULL,
  tbl_paciente_pac_num_id_pac INTEGER UNSIGNED NOT NULL,
  txt_descricao_lau TEXT NULL,
  dta_data_lau DATE NULL,
  PRIMARY KEY(num_id_lau),
  INDEX fk_pac_lau(tbl_paciente_pac_num_id_pac),
  INDEX fk_med_lau(tbl_medico_med_num_id_med),
  INDEX fk_usu_lau(tbl_usuario_usu_num_id_usu)
);

CREATE TABLE tbl_log_paciente_lp (
  num_id_lp INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tbl_paciente_pac_num_id_pac INTEGER UNSIGNED NOT NULL,
  txt_acao_lp VARCHAR(20) NULL,
  dth_registro_lp DATETIME NULL,
  PRIMARY KEY(num_id_lp),
  INDEX fk_paciente_log(tbl_paciente_pac_num_id_pac)
);

CREATE TABLE tbl_medicamentos_medi (
  num_id_medi INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  txt_nome_medi VARCHAR(50) NULL,
  txt_nomecientifico_medi VARCHAR(50) NULL,
  txt_contraindicacao_medi VARCHAR(100) NULL,
  txt_efeitocolateral_medi VARCHAR(100) NULL,
  txt_uso_medi VARCHAR(20) NULL,
  txt_posologia_medi TEXT NULL,
  txt_obs_medi TEXT NULL,
  txt_ativo_medi VARCHAR(3) NULL,
  PRIMARY KEY(num_id_medi)
);

CREATE TABLE tbl_medico_med (
  num_id_med INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tbl_especialidade_esp_num_id_esp INTEGER UNSIGNED NOT NULL,
  tbl_usuario_usu_num_id_usu INTEGER UNSIGNED NOT NULL,
  txt_conselho_med VARCHAR(20) NULL,
  txt_uf_med VARCHAR(2) NULL,
  txt_documento_med VARCHAR(20) NULL,
  dta_incricao_med DATE NULL,
  txt_nome_med VARCHAR(100) NULL,
  txt_cpf_med VARCHAR(11) NULL,
  txt_telefone_med VARCHAR(20) NULL,
  txt_sexo_med VARCHAR(10) NULL,
  txt_observacao_med TEXT NULL,
  dta_registro_med DATE NULL,
  num_repasseexame_med INTEGER UNSIGNED NULL,
  num_repasseconsulta_med INTEGER UNSIGNED NULL,
  num_repasseparticular_med INTEGER UNSIGNED NULL,
  num_idsistema_med INTEGER UNSIGNED NULL,
  txt_ativo_med VARCHAR(3) NULL,
  PRIMARY KEY(num_id_med),
  INDEX fk_usu_med(tbl_usuario_usu_num_id_usu),
  INDEX fk_esp_med(tbl_especialidade_esp_num_id_esp)
);

CREATE TABLE tbl_paciente_pac (
  num_id_pac INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tbl_categoria_cat_num_id_cat INTEGER UNSIGNED NOT NULL,
  tbl_usuario_usu_num_id_usu INTEGER UNSIGNED NOT NULL,
  txt_nome_pac VARCHAR(100) NOT NULL,
  txt_cpf_pac VARCHAR(11) NULL,
  txt_cor_pac VARCHAR(20) NULL,
  txt_sexo_pac VARCHAR(10) NULL,
  dta_datanascimento_pac DATE NULL,
  txt_email_pac VARCHAR(100) NULL,
  txt_telefone_pac VARCHAR(20) NULL,
  txt_senha_pac VARCHAR(10) NULL,
  txt_estadocivil_pac VARCHAR(20) NULL,
  txt_cep_pac VARCHAR(11) NULL,
  txt_logradouro_pac VARCHAR(100) NULL,
  num_numero_pac INTEGER UNSIGNED NULL,
  txt_complemento_pac VARCHAR(50) NULL,
  txt_bairro_pac VARCHAR(50) NULL,
  txt_cidade_pac VARCHAR(20) NULL,
  txt_estado_pac VARCHAR(2) NULL,
  txt_observacoes_pac TEXT NULL,
  txt_matricula_pac VARCHAR(50) NULL,
  dta_registro_pac DATETIME NULL,
  num_usuario_alteracao_pac INT(10) NULL,
  dth_alteracao_pac DATETIME NULL,
  dta_ultimavisita_pac DATE NULL,
  txt_ativo_pac VARCHAR(3) NULL,
  PRIMARY KEY(num_id_pac),
  INDEX fk_usu_pac(tbl_usuario_usu_num_id_usu),
  INDEX fk_cat_pac(tbl_categoria_cat_num_id_cat),
  INDEX ix_nome_pac(txt_nome_pac)
);

CREATE TABLE tbl_pagamento_pag (
  num_id_pag INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tbl_formapagamento_fp_num_id_fp INTEGER UNSIGNED NOT NULL,
  tbl_usuario_usu_num_id_usu INTEGER UNSIGNED NOT NULL,
  val_valor_pag DOUBLE(8,2) NULL,
  txt_nsu_pag INTEGER UNSIGNED NULL,
  num_autorizacao_pag INT NULL,
  txt_bandeira_pag VARCHAR(20) NULL,
  dth_datahora_pag DATETIME NULL,
  PRIMARY KEY(num_id_pag),
  INDEX fk_usu_pag(tbl_usuario_usu_num_id_usu),
  INDEX fk_fp_pag(tbl_formapagamento_fp_num_id_fp)
);

CREATE TABLE tbl_painelvagas_pv (
  num_id_pv INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tbl_agenda_agenn_num_id_agen INTEGER UNSIGNED NOT NULL,
  dta_data_pv DATE NULL,
  qtd_disponivel_pv INTEGER UNSIGNED NULL,
  PRIMARY KEY(num_id_pv),
  INDEX fk_age_pv(tbl_agenda_agenn_num_id_agen)
);

CREATE TABLE tbl_parente_par (
  num_id_par INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  num_id_pac_par INTEGER UNSIGNED NULL,
  txt_grau_par VARCHAR(20) NULL,
  PRIMARY KEY(num_id_par)
);

CREATE TABLE tbl_prioridade_pri (
  num_id_pri INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  txt_nome_pri VARCHAR(20) NULL,
  txt_descricao_pri VARCHAR(200) NULL,
  txt_ativo_pri CHAR(1) NULL,
  PRIMARY KEY(num_id_pri)
);

CREATE TABLE tbl_procedimentos_pro (
  num_id_pro INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  txt_nome_pro VARCHAR(50) NULL,
  txt_descricao_pro VARCHAR(100) NULL,
  txt_tipo_pro VARCHAR(20) NULL,
  txt_ativo_pro VARCHAR(3) NULL,
  PRIMARY KEY(num_id_pro)
);

CREATE TABLE tbl_profissao_pro (
  num_id_pro INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  txt_nome_pro VARCHAR(50) NULL,
  txt_descricao_pro VARCHAR(50) NULL,
  txt_status_pro VARCHAR(3) NULL,
  PRIMARY KEY(num_id_pro)
);

CREATE TABLE tbl_receita_rec (
  num_id_rec INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tbl_usuario_usu_num_id_usu INTEGER UNSIGNED NOT NULL,
  tbl_medico_med_num_id_med INTEGER UNSIGNED NOT NULL,
  tbl_paciente_pac_num_id_pac INTEGER UNSIGNED NOT NULL,
  dta_data_rec DATE NULL,
  PRIMARY KEY(num_id_rec),
  INDEX fk_pac_rec(tbl_paciente_pac_num_id_pac),
  INDEX fk_med_rec(tbl_medico_med_num_id_med),
  INDEX fk_usu_rec(tbl_usuario_usu_num_id_usu)
);

CREATE TABLE tbl_refpagamento_refpag (
  num_id_refpag INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tbl_visita_vis_num_id_vis INTEGER UNSIGNED NOT NULL,
  tbl_pagamento_pag_num_id_pag INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(num_id_refpag),
  INDEX fk_pag_refpag(tbl_pagamento_pag_num_id_pag),
  INDEX fk_vis_refpag(tbl_visita_vis_num_id_vis)
);

CREATE TABLE tbl_resultado_exame_re (
  num_id_re INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tbl_procedimentos_pro_num_id_pro INTEGER UNSIGNED NOT NULL,
  tbl_medico_med_num_id_med INTEGER UNSIGNED NOT NULL,
  tbl_usuario_usu_num_id_usu INTEGER UNSIGNED NOT NULL,
  tbl_paciente_pac_num_id_pac INTEGER UNSIGNED NOT NULL,
  dth_datahora_re DATETIME NULL,
  txt_nomearquivo_re VARCHAR(50) NULL,
  txt_status_re CHAR(1) NULL,
  PRIMARY KEY(num_id_re),
  INDEX fk_pac_re(tbl_paciente_pac_num_id_pac),
  INDEX fk_usu_re(tbl_usuario_usu_num_id_usu),
  INDEX fk_med_re(tbl_medico_med_num_id_med),
  INDEX fk_pro_re(tbl_procedimentos_pro_num_id_pro)
);

CREATE TABLE tbl_tipousuario_tu (
  num_id_tu INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  txt_nome_tu VARCHAR(20) NULL,
  txt_descricao_tu VARCHAR(200) NULL,
  txt_ativo_tu CHAR(1) NULL,
  PRIMARY KEY(num_id_tu)
);

CREATE TABLE tbl_usuario_usu (
  num_id_usu INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tbl_tipousuario_tu_num_id_tu INTEGER UNSIGNED NOT NULL,
  txt_nome_usu VARCHAR(100) NULL,
  txt_login_usu VARCHAR(50) NULL,
  txt_senha_usu VARCHAR(50) NULL,
  txt_email_usu VARCHAR(100) NULL,
  txt_ativo_usu CHAR(1) NULL,
  PRIMARY KEY(num_id_usu),
  INDEX fk_tu_usu(tbl_tipousuario_tu_num_id_tu),
  UNIQUE INDEX ix_login_usu(txt_login_usu)
);

CREATE TABLE tbl_visita_vis (
  num_id_vis INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tbl_prioridade_pri_num_id_pri INTEGER UNSIGNED NOT NULL,
  tbl_procedimentos_pro_num_id_pro INTEGER UNSIGNED NOT NULL,
  tbl_categoria_cat_num_id_cat INTEGER UNSIGNED NOT NULL,
  tbl_usuario_usu_num_id_usu INTEGER UNSIGNED NOT NULL,
  tbl_paciente_pac_num_id_pac INTEGER UNSIGNED NOT NULL,
  tbl_medico_med_num_id_med INTEGER UNSIGNED NOT NULL,
  txt_solicitacao_vis VARCHAR(20) NULL,
  txt_autorizacao_vis VARCHAR(20) NULL,
  val_repassemedico_vis DOUBLE(8,2) NULL,
  val_procedimento_vis DOUBLE(8,2) NULL,
  dta_data_vis DATE NULL,
  hor_hora_vis TIME NULL,
  txt_sobeescada_vis VARCHAR(3) NULL,
  txt_observacao_vis TEXT NULL,
  dth_registro_vis DATETIME NULL,
  num_usuarioconfirmacao_vis INTEGER UNSIGNED NULL,
  dth_confirmacao_vis DATETIME NULL,
  num_usuarioalteracao_vis INTEGER UNSIGNED NULL,
  dth_alteracao_vis DATETIME NULL,
  num_usuariorecepcao_vis INTEGER UNSIGNED NULL,
  dth_chegada_vis DATETIME NULL,
  num_usuariomedico_vis INTEGER UNSIGNED NULL,
  dth_atendimento_vis DATETIME NULL,
  txt_status_vis VARCHAR(15) NULL,
  PRIMARY KEY(num_id_vis),
  INDEX fk_med_vis(tbl_medico_med_num_id_med),
  INDEX fk_pac_vis(tbl_paciente_pac_num_id_pac),
  INDEX fk_usu_vis(tbl_usuario_usu_num_id_usu),
  INDEX fk_cat_vis(tbl_categoria_cat_num_id_cat),
  INDEX fk_pro_vis(tbl_procedimentos_pro_num_id_pro),
  INDEX fk_pri_vis(tbl_prioridade_pri_num_id_pri)
);


