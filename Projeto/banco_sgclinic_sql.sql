CREATE TABLE tbl_formapagamento_fp (
  num_id_fp INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  txt_nome_fp VARCHAR(20) NULL,
  txt_desricao_fp VARCHAR(200) NULL,
  txt_ativo_fp VARCHAR(3) NULL,
  PRIMARY KEY(num_id_fp)
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

CREATE TABLE tbl_especialidade_esp (
  num_id_esp INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  txt_nome_esp VARCHAR(50) NULL,
  txt_ativo_esp CHAR(3) NULL,
  PRIMARY KEY(num_id_esp)
);

CREATE TABLE tbl_usuario_usu (
  num_id_usu INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  txt_tipo_usu VARCHAR(20) NULL,
  txt_nome_usu VARCHAR(100) NULL,
  txt_login_usu VARCHAR(50) NULL,
  txt_senha_usu VARCHAR(100) NULL,
  txt_email_usu VARCHAR(100) NULL,
  txt_telefone_usu VARCHAR(20) NULL,
  dth_registro_usu DATETIME NULL,
  txt_ativo_usu VARCHAR(3) NULL,
  PRIMARY KEY(num_id_usu)
);

CREATE TABLE tbl_medicamentos_medi (
  num_id_medi INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  txt_nome_medi VARCHAR(50) NULL,
  txt_nomecientifico_medi VARCHAR(50) NULL,
  txt_contraindicacao_medi VARCHAR(100) NULL,
  txt_efeitocolateral_medi VARCHAR(100) NULL,
  txt_uso_medi VARCHAR(100) NULL,
  txt_posologia_medi TEXT NULL,
  txt_obs_medi TEXT NULL,
  txt_ativo_medi VARCHAR(3) NULL,
  PRIMARY KEY(num_id_medi)
);

CREATE TABLE tbl_feriados_fer (
  num_id_fer INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tbl_usuario_usu_num_id_usu INTEGER UNSIGNED NOT NULL,
  dta_data_fer DATE NULL,
  txt_permite_agendar_fer VARCHAR(3) NULL,
  txt_ativo_fer VARCHAR(3) NULL,
  PRIMARY KEY(num_id_fer),
  INDEX fk_usuario_feriado(tbl_usuario_usu_num_id_usu)
);

CREATE TABLE tbl_estado_civil_ec (
  num_id_ec INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tbl_usuario_usu_num_id_usu INTEGER UNSIGNED NOT NULL,
  txt_nome_ec VARCHAR(20) NULL,
  txt_ativo_ec VARCHAR(3) NULL,
  PRIMARY KEY(num_id_ec),
  INDEX fk_usuario_estado_civil(tbl_usuario_usu_num_id_usu)
);

CREATE TABLE tbl_cor_cor (
  num_id_cor INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tbl_usuario_usu_num_id_usu INTEGER UNSIGNED NOT NULL,
  txt_nome_cor VARCHAR(20) NULL,
  txt_ativo_cor VARCHAR(3) NULL,
  PRIMARY KEY(num_id_cor),
  INDEX fk_usuario_cor(tbl_usuario_usu_num_id_usu)
);

CREATE TABLE tbl_categoria_cat (
  num_id_cat INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tbl_usuario_usu_num_id_usu INTEGER UNSIGNED NOT NULL,
  txt_nome_cat VARCHAR(50) NULL,
  num_retorno_cat INTEGER UNSIGNED NULL,
  txt_gera_remessa_convenio_cat VARCHAR(3) NULL,
  txt_gera_receber_caixa_cat VARCHAR(3) NULL,
  txt_ativo_cat VARCHAR(3) NULL,
  PRIMARY KEY(num_id_cat),
  INDEX fk_usuario_categoria(tbl_usuario_usu_num_id_usu)
);

CREATE TABLE tbl_procedimentos_pro (
  num_id_pro INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tbl_usuario_usu_num_id_usu INTEGER UNSIGNED NOT NULL,
  txt_nome_pro VARCHAR(50) NULL,
  txt_descricao_pro VARCHAR(100) NULL,
  txt_tipo_pro VARCHAR(20) NULL,
  txt_recomendacoes_pro TEXT NULL,
  txt_ativo_pro VARCHAR(3) NULL,
  PRIMARY KEY(num_id_pro),
  INDEX fk_usuario_procedimento(tbl_usuario_usu_num_id_usu)
);

CREATE TABLE tbl_profissao_prof (
  num_id_prof INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tbl_usuario_usu_num_id_usu INTEGER UNSIGNED NOT NULL,
  txt_nome_prof VARCHAR(20) NULL,
  txt_ativo_prof VARCHAR(3) NULL,
  PRIMARY KEY(num_id_prof),
  INDEX fk_usuario_profissao(tbl_usuario_usu_num_id_usu)
);

CREATE TABLE tbl_medico_med (
  num_id_med INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tbl_especialidade_esp_num_id_esp INTEGER UNSIGNED NOT NULL,
  tbl_usuario_usu_num_id_usu INTEGER UNSIGNED NOT NULL,
  txt_registro_med VARCHAR(20) NULL,
  txt_nome_med VARCHAR(100) NULL,
  txt_cpf_med VARCHAR(11) NULL,
  txt_telefone_med VARCHAR(20) NULL,
  txt_sexo_med VARCHAR(20) NULL,
  txt_observacao_med TEXT NULL,
  dth_registro_med DATETIME NULL,
  num_repasseexame_med INTEGER UNSIGNED NULL,
  num_repasseconsulta_med INTEGER UNSIGNED NULL,
  num_repasseparticular_med INTEGER UNSIGNED NULL,
  num_idsistema_med INTEGER UNSIGNED NULL,
  txt_ativo_med VARCHAR(3) NULL,
  PRIMARY KEY(num_id_med),
  INDEX fk_usuario_medico(tbl_usuario_usu_num_id_usu),
  INDEX fk_especialidade_medico(tbl_especialidade_esp_num_id_esp)
);

CREATE TABLE tbl_agenda_agen (
  num_id_agen INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tbl_usuario_usu_num_id_usu INTEGER UNSIGNED NOT NULL,
  tbl_medico_med_num_id_med INTEGER UNSIGNED NOT NULL,
  txt_dia_semana_agen VARCHAR(20) NULL,
  hor_inicio_agen TIME NULL,
  hor_final_agen TIME NULL,
  num_quantidade_agen INTEGER UNSIGNED NULL,
  num_duracao_atendimento_agen INTEGER UNSIGNED NULL,
  dth_registro_agen DATETIME NULL,
  num_usuario_desativacao_agen INTEGER UNSIGNED NULL,
  dth_desativacao_agen DATETIME NULL,
  txt_observacao_agen VARCHAR(50) NULL,
  txt_status_agen VARCHAR(20) NULL,
  PRIMARY KEY(num_id_agen),
  INDEX fk_medico_agenda(tbl_medico_med_num_id_med),
  INDEX fk_usuario_agenda(tbl_usuario_usu_num_id_usu)
);

CREATE TABLE tbl_bloqueio_agenda_blage (
  num_id_blage INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tbl_medico_med_num_id_med INTEGER UNSIGNED NOT NULL,
  tbl_usuario_usu_num_id_usu INTEGER UNSIGNED NOT NULL,
  dta_data_blage DATE NULL,
  dta_registro_blage DATETIME NULL,
  PRIMARY KEY(num_id_blage),
  INDEX tbl_bloqueio_agenda_blage_FKIndex1(tbl_usuario_usu_num_id_usu),
  INDEX tbl_bloqueio_agenda_blage_FKIndex2(tbl_medico_med_num_id_med)
);

CREATE TABLE tbl_honorarios_hon (
  num_id_hon INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tbl_usuario_usu_num_id_usu INTEGER UNSIGNED NOT NULL,
  tbl_medico_med_num_id_med INTEGER UNSIGNED NOT NULL,
  dta_inicial_hon DATE NULL,
  dta_final_hon DATE NULL,
  txt_notafiscal_hon VARCHAR(20) NULL,
  txt_arquivo_notafiscal_hon VARCHAR(50) NULL,
  dta_pagamento_hon DATE NULL,
  val_total_hon DOUBLE(8,2) NULL,
  val_receber_hon DOUBLE(8,2) NULL,
  dth_registro_hon DATETIME NULL,
  txt_status_hon VARCHAR(20) NULL,
  PRIMARY KEY(num_id_hon),
  INDEX fk_medico_honorario(tbl_medico_med_num_id_med),
  INDEX fk_usuario_honorario(tbl_usuario_usu_num_id_usu)
);

CREATE TABLE tbl_cat_pro (
  num_id_cat_pro INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tbl_usuario_usu_num_id_usu INTEGER UNSIGNED NOT NULL,
  tbl_procedimentos_pro_num_id_pro INTEGER UNSIGNED NOT NULL,
  tbl_categoria_cat_num_id_cat INTEGER UNSIGNED NOT NULL,
  val_valor_cat_pro DOUBLE(8,2) NULL,
  txt_ativo_cat_pro VARCHAR(3) NULL,
  PRIMARY KEY(num_id_cat_pro),
  INDEX fk_categoria_procedimento(tbl_categoria_cat_num_id_cat),
  INDEX fk_procedimento_categoria(tbl_procedimentos_pro_num_id_pro),
  INDEX fk_usuario_categoria_procedimento(tbl_usuario_usu_num_id_usu)
);

CREATE TABLE tbl_paciente_pac (
  num_id_pac INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tbl_profissao_prof_num_id_prof INTEGER UNSIGNED NULL,
  tbl_estado_civil_ec_num_id_ec INTEGER UNSIGNED NULL,
  tbl_cor_cor_num_id_cor INTEGER UNSIGNED NULL,
  tbl_medico_med_num_id_med INTEGER UNSIGNED NOT NULL,
  tbl_categoria_cat_num_id_cat INTEGER UNSIGNED NOT NULL,
  tbl_usuario_usu_num_id_usu INTEGER UNSIGNED NULL,
  txt_nome_pac VARCHAR(100) NOT NULL,
  txt_cpf_pac VARCHAR(11) NULL,
  txt_rg_pac VARCHAR(15) NULL,
  dta_datanascimento_pac DATE NOT NULL,
  txt_email_pac VARCHAR(100) NULL,
  txt_telefone_pac VARCHAR(20) NOT NULL,
  txt_senha_pac VARCHAR(10) NULL,
  txt_cep_pac VARCHAR(11) NULL,
  txt_logradouro_pac VARCHAR(100) NULL,
  num_numero_pac INTEGER UNSIGNED NULL,
  txt_complemento_pac VARCHAR(50) NULL,
  txt_bairro_pac VARCHAR(50) NULL,
  txt_cidade_pac VARCHAR(20) NULL,
  txt_estado_pac VARCHAR(2) NULL,
  txt_matricula_pac VARCHAR(50) NULL,
  val_saldo_pac DOUBLE(8,2) NULL,
  txt_pne_pac VARCHAR(3) NULL,
  txt_cns_pac VARCHAR(100) NULL,
  txt_carteira_pac VARCHAR(100) NULL,
  dta_vencimento_carteira_pac DATE NULL,
  dth_registro_pac DATETIME NULL,
  num_usuario_alteracao_pac INT(10) NULL,
  dth_alteracao_pac DATETIME NULL,
  txt_bloquear_agendamento_pac VARCHAR(3) NULL,
  txt_observacoes_pac TEXT NULL,
  dta_ultima_visita_pac DATE NULL,
  txt_ativo_pac VARCHAR(3) NULL,
  PRIMARY KEY(num_id_pac),
  INDEX fk_usuario_cadastro_paciente(tbl_usuario_usu_num_id_usu),
  INDEX fk_categoria_paciente(tbl_categoria_cat_num_id_cat),
  INDEX fk_medico_paciente(tbl_medico_med_num_id_med),
  INDEX fk_cor_paciente(tbl_cor_cor_num_id_cor),
  INDEX fk_estado_civil_paciente(tbl_estado_civil_ec_num_id_ec),
  INDEX fk_profissao_paciente(tbl_profissao_prof_num_id_prof)
);

CREATE TABLE tbl_log_paciente_lp (
  num_id_lp INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tbl_paciente_pac_num_id_pac INTEGER UNSIGNED NOT NULL,
  txt_acao_lp VARCHAR(20) NULL,
  dth_registro_lp DATETIME NULL,
  PRIMARY KEY(num_id_lp),
  INDEX fk_paciente_log(tbl_paciente_pac_num_id_pac)
);

CREATE TABLE tbl_parente_par (
  num_id_par INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tbl_paciente_pac_num_id_pac INTEGER UNSIGNED NOT NULL,
  num_id_pac_par INTEGER UNSIGNED NULL,
  txt_grau_par VARCHAR(20) NULL,
  PRIMARY KEY(num_id_par),
  INDEX fk_paciente_parente(tbl_paciente_pac_num_id_pac)
);

CREATE TABLE tbl_receita_rec (
  num_id_rec INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tbl_usuario_usu_num_id_usu INTEGER UNSIGNED NOT NULL,
  tbl_paciente_pac_num_id_pac INTEGER UNSIGNED NOT NULL,
  dta_data_rec DATE NULL,
  PRIMARY KEY(num_id_rec),
  INDEX fk_paciente_receita(tbl_paciente_pac_num_id_pac),
  INDEX fk_usuario_receita(tbl_usuario_usu_num_id_usu)
);

CREATE TABLE tbl_laudo_lau (
  num_id_lau INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tbl_usuario_usu_num_id_usu INTEGER UNSIGNED NOT NULL,
  tbl_paciente_pac_num_id_pac INTEGER UNSIGNED NOT NULL,
  txt_descricao_lau TEXT NULL,
  dta_data_lau DATE NULL,
  PRIMARY KEY(num_id_lau),
  INDEX fk_paciente_laudo(tbl_paciente_pac_num_id_pac),
  INDEX fk_usuario_laudo(tbl_usuario_usu_num_id_usu)
);

CREATE TABLE tbl_mensagens_paciente_mp (
  num_id_mp INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tbl_paciente_pac_num_id_pac INTEGER UNSIGNED NOT NULL,
  tbl_usuario_usu_num_id_usu INTEGER UNSIGNED NOT NULL,
  txt_mensagem_mp VARCHAR(255) NULL,
  dth_registro_mp DATETIME NULL,
  PRIMARY KEY(num_id_mp),
  INDEX fk_usuario_mensagem(tbl_usuario_usu_num_id_usu),
  INDEX fk_paciente_mensagem(tbl_paciente_pac_num_id_pac)
);

CREATE TABLE tbl_consulta_con (
  num_id_con INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tbl_paciente_pac_num_id_pac INTEGER UNSIGNED NOT NULL,
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
  INDEX fk_usuario_consulta(tbl_usuario_usu_num_id_usu),
  INDEX fk_paciente_consulta(tbl_paciente_pac_num_id_pac)
);

CREATE TABLE tbl_exame_exa (
  num_id_exa INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tbl_paciente_pac_num_id_pac INTEGER UNSIGNED NOT NULL,
  txt_dados_exa TEXT NOT NULL,
  tbl_usuario_usu_num_id_usu INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(num_id_exa),
  INDEX fk_usuario_exame(tbl_usuario_usu_num_id_usu),
  INDEX fk_paciente_exame(tbl_paciente_pac_num_id_pac)
);

CREATE TABLE tbl_itensreceita_itrec (
  num_id_itrec INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tbl_medicamentos_medi_num_id_medi INTEGER UNSIGNED NOT NULL,
  tbl_receita_rec_num_id_rec INTEGER UNSIGNED NOT NULL,
  txt_observacoes_itrec VARCHAR(100) NULL,
  PRIMARY KEY(num_id_itrec),
  INDEX fk_receita_itensreceita(tbl_receita_rec_num_id_rec),
  INDEX fk_medicamentos_itensreceita(tbl_medicamentos_medi_num_id_medi)
);

CREATE TABLE tbl_recebimento_rec (
  num_id_rec INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tbl_paciente_pac_num_id_pac INTEGER UNSIGNED NOT NULL,
  tbl_formapagamento_fp_num_id_fp INTEGER UNSIGNED NOT NULL,
  tbl_usuario_usu_num_id_usu INTEGER UNSIGNED NOT NULL,
  val_valor_rec DOUBLE(8,2) NULL,
  txt_nsu_rec INTEGER UNSIGNED NULL,
  num_autorizacao_rec INTEGER UNSIGNED NULL,
  txt_descricao_rec VARCHAR(255) NULL,
  txt_nf_nome_paciente_rec VARCHAR(3) NULL,
  num_id_paciente_nf_rec INTEGER UNSIGNED NULL,
  dth_datahora_rec DATETIME NULL,
  PRIMARY KEY(num_id_rec),
  INDEX fk_usuario_recebimento(tbl_usuario_usu_num_id_usu),
  INDEX fk_formapagamento_recebimento(tbl_formapagamento_fp_num_id_fp),
  INDEX fk_paciente_recebimento(tbl_paciente_pac_num_id_pac)
);

CREATE TABLE tbl_agendamento_age (
  num_id_age INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tbl_medico_med_num_id_med INTEGER UNSIGNED NOT NULL,
  tbl_paciente_pac_num_id_pac INTEGER UNSIGNED NOT NULL,
  tbl_usuario_usu_num_id_usu INTEGER UNSIGNED NOT NULL,
  txt_solicitacao_age VARCHAR(20) NULL,
  txt_arquivo_solicitacao_age VARCHAR(100) NULL,
  dta_data_age DATE NULL,
  hor_hora_age TIME NULL,
  txt_observacao_age VARCHAR(100) NULL,
  dth_registro_age DATETIME NULL,
  num_usuario_alteracao_age INTEGER UNSIGNED NULL,
  dth_alteracao_age DATETIME NULL,
  num_usuario_confirmacao_age INTEGER UNSIGNED NULL,
  dth_confirmacao_age DATETIME NULL,
  txt_status_age VARCHAR(20) NULL,
  PRIMARY KEY(num_id_age),
  INDEX fk_usuario_agendamento(tbl_usuario_usu_num_id_usu),
  INDEX fk_paciente_agendamento(tbl_paciente_pac_num_id_pac),
  INDEX fk_medico_agendamento(tbl_medico_med_num_id_med)
);

CREATE TABLE tbl_item_agendamento_itage (
  num_id_itage INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tbl_categoria_cat_num_id_cat INTEGER UNSIGNED NOT NULL,
  tbl_procedimentos_pro_num_id_pro INTEGER UNSIGNED NOT NULL,
  tbl_agendamento_age_num_id_age INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(num_id_itage),
  INDEX fk_agendamento_item_agendamento(tbl_agendamento_age_num_id_age),
  INDEX fk_procedimento_item_agendamento(tbl_procedimentos_pro_num_id_pro),
  INDEX fk_categoria_item_agendamento(tbl_categoria_cat_num_id_cat)
);

CREATE TABLE tbl_resultado_exame_re (
  num_id_re INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tbl_procedimentos_pro_num_id_pro INTEGER UNSIGNED NOT NULL,
  tbl_medico_med_num_id_med INTEGER UNSIGNED NOT NULL,
  tbl_usuario_usu_num_id_usu INTEGER UNSIGNED NOT NULL,
  tbl_paciente_pac_num_id_pac INTEGER UNSIGNED NOT NULL,
  dth_datahora_re DATETIME NULL,
  txt_nomearquivo_re VARCHAR(50) NULL,
  txt_status_re VARCHAR(3) NULL,
  PRIMARY KEY(num_id_re),
  INDEX fk_pac_re(tbl_paciente_pac_num_id_pac),
  INDEX fk_usu_re(tbl_usuario_usu_num_id_usu),
  INDEX fk_med_re(tbl_medico_med_num_id_med),
  INDEX fk_pro_re(tbl_procedimentos_pro_num_id_pro)
);

CREATE TABLE tbl_atendimento_aten (
  num_id_aten INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tbl_procedimentos_pro_num_id_pro INTEGER UNSIGNED NOT NULL,
  tbl_categoria_cat_num_id_cat INTEGER UNSIGNED NOT NULL,
  tbl_usuario_usu_num_id_usu INTEGER UNSIGNED NOT NULL,
  tbl_paciente_pac_num_id_pac INTEGER UNSIGNED NOT NULL,
  tbl_medico_med_num_id_med INTEGER UNSIGNED NOT NULL,
  dth_recepcao_aten DATETIME NULL,
  txt_guia_aten VARCHAR(100) NULL,
  txt_arquivo_guia_aten VARCHAR(100) NULL,
  txt_autorizacao_aten VARCHAR(100) NULL,
  txt_arquivo_autorizacao_aten VARCHAR(100) NULL,
  val_valor_aten DOUBLE(8,2) NULL,
  txt_tipo_desconto_aten VARCHAR(20) NULL,
  val_desconto_aten DOUBLE(8,2) NULL,
  val_total_aten DOUBLE(8,2) NULL,
  txt_observacao_aten VARCHAR(100) NULL,
  txt_prioridade_aten VARCHAR(20) NULL,
  dth_medico_aten DATETIME NULL,
  dth_termino_aten DATETIME NULL,
  num_usuario_alteracao_aten INTEGER UNSIGNED NULL,
  dth_alteracao_aten DATETIME NULL,
  txt_status_convenio_aten VARCHAR(20) NULL,
  txt_status_honorario_aten VARCHAR(20) NULL,
  val_medico_aten DOUBLE(8,2) NULL,
  val_clinica_aten DOUBLE(8,2) NULL,
  txt_status_aten VARCHAR(20) NULL,
  dth_registro_aten DATETIME NULL,
  PRIMARY KEY(num_id_aten),
  INDEX fk_medico_atendimento(tbl_medico_med_num_id_med),
  INDEX fk_paciente_atendimento(tbl_paciente_pac_num_id_pac),
  INDEX fk_usuario_atendimento(tbl_usuario_usu_num_id_usu),
  INDEX fk_categoria_atendimento(tbl_categoria_cat_num_id_cat),
  INDEX fk_procedimento_atendimento(tbl_procedimentos_pro_num_id_pro)
);


