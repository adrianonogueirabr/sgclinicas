SELECT paciente.num_id_pac, medico.txt_nome_med, categoria.txt_nome_cat, usuario.txt_login_usu as 'usuario_cadastro', profissao.txt_nome_pro, paciente.txt_nome_pac, 

paciente.txt_cpf_pac, paciente.txt_rg_pac, paciente.txt_cor_pac, paciente.txt_sexo_pac, paciente.dta_datanascimento_pac, paciente.txt_email_pac, paciente.txt_telefone_pac, paciente.txt_senha_pac, 

paciente.txt_estadocivil_pac, 

paciente.txt_cep_pac, paciente.txt_logradouro_pac, paciente.num_numero_pac, paciente.txt_complemento_pac, paciente.txt_bairro_pac, paciente.txt_cidade_pac, paciente.txt_estado_pac, 

paciente.txt_matricula_pac, 

paciente.val_saldo_pac, paciente.txt_pne_pac, paciente.txt_cns_pac, paciente.txt_carteira_pac, paciente.dta_vencimento_carteira_pac, paciente.dth_registro_pac, usuarioalt.txt_login_usu as 'usuario_alteracao', 

paciente.dth_alteracao_pac, paciente.txt_bloquear_agendamento_pac, paciente.txt_observacoes_pac, paciente.dta_ultima_visita_pac, paciente.txt_ativo_pac 

FROM tbl_paciente_pac paciente

LEFT JOIN tbl_profissao_pro profissao ON profissao.num_id_pro = paciente.tbl_profissao_pro_num_id_pro
LEFT JOIN tbl_medico_med medico ON medico.num_id_med = paciente.tbl_medico_med_num_id_med
LEFT JOIN tbl_categoria_cat categoria ON categoria.num_id_cat = paciente.tbl_categoria_cat_num_id_cat
LEFT JOIN tbl_usuario_usu usuario ON usuario.num_id_usu = paciente.tbl_usuario_usu_num_id_usu 
LEFT JOIN tbl_usuario_usu usuarioalt ON usuarioalt.num_id_usu = paciente.num_usuario_alteracao_pac 


WHERE 1


SELECT C.TXT_RAZAO_CLI,F.TBL_CLIENTE_CLI_NUM_ID_CLI , F.NUM_ID_FR, F.TXT_ATIVO_FR, T.TXT_NOME_TIP, M.TXT_NOME_MAR, MO.TXT_NOME_MOD, 
                                    
                                        F.TXT_PLACA_FR, F.TXT_CHASSI_FR, F.DTH_REGISTRO_FR,F.DTH_ALTERACAO_FR, CO.TXT_NOME_COR 

                                        FROM tbl_frota_fr F 

                                        LEFT JOIN TBL_CLIENTE_CLI C ON C.NUM_ID_CLI = F.TBL_CLIENTE_CLI_NUM_ID_CLI 
                                        LEFT JOIN TBL_TIPO_TIP T ON T.NUM_ID_TIP = F.TBL_TIPO_TIP_NUM_ID_TIP 
                                        LEFT JOIN TBL_MARCA_MAR M ON M.NUM_ID_MAR = F.TBL_MARCA_MAR_NUM_ID_MAR
                                        LEFT JOIN TBL_MODELO_MOD MO ON MO.NUM_ID_MOD = F.TBL_MODELO_MOD_NUM_ID_MOD
                                        LEFT JOIN TBL_COR_COR CO ON CO.NUM_ID_COR = F.TBL_COR_COR_NUM_ID_COR
                                
                                        WHERE F.NUM_ID_FR = $row->TBL_FROTA_FR_NUM_ID_FR



//historico de pacientes
SELECT atendimento.num_id_vis,
atendimento.tbl_paciente_pac_num_id_pac,
atendimento.dth_registro_aten,
medico.txt_nome_med,
procedimentos.txt_nome_pro,
categoria.txt_nome_cat 

FROM tbl_atendimento_aten atendimento

LEFT JOIN tbl_medico_med medico ON medico.num_id_med = atendimento.tbl_medico_med_num_id_med
LEFT JOIN tbl_procedimentos_pro procedimentos ON procedimentos.num_id_pro = atendimento.tbl_procedimentos_pro_num_id_pro
LEFT JOIN tbl_categoria_cat categoria ON categoria.num_id_cat = atendimento.tbl_categoria_cat_num_id_cat

WHERE tbl_paciente_pac_num_id_pac = 1



// agenda de medicos
SELECT agenda.num_id_agen,medico.txt_nome_med,agenda.txt_dia_semana_agen,agenda.hor_inicio_agen,agenda.hor_final_agen FROM tbl_agenda_agen agenda LEFT JOIN tbl_medico_med medico ON medico.num_id_med = agenda.tbl_medico_med_num_id_med;


//comando para apagar registros duplicados pelo mais antigo
DELETE a FROM tbl_procedimentos_pro AS a, tbl_procedimentos_pro AS b WHERE a.txt_nome_pro=b.txt_nome_pro AND a.num_id_pro < b.num_id_pro 

//comando para agendamentos gerais criando outra tabela teste
create table teste
SELECT agendamento.hor_hora_age,agendamento.dta_data_age,medico.txt_nome_med, agendamento.num_id_age, paciente.txt_nome_pac, paciente.txt_telefone_pac, usuario.txt_login_usu, agendamento.txt_observacao_age 
FROM tbl_agendamento_age agendamento 
LEFT JOIN tbl_paciente_pac paciente ON paciente.num_id_pac = agendamento.tbl_paciente_pac_num_id_pac 
LEFT JOIN tbl_medico_med medico ON medico.num_id_med = agendamento.tbl_medico_med_num_id_med 
LEFT JOIN tbl_usuario_usu usuario ON usuario.num_id_usu = agendamento.tbl_usuario_usu_num_id_usu;


//comando para buscar horario com detalhes do agendamento e itens de agendamento
SELECT agendamento.hor_hora_age, agendamento.num_id_age, paciente.txt_nome_pac, paciente.txt_telefone_pac, usuario.txt_login_usu, agendamento.txt_observacao_age, procedimento.txt_nome_pro, categoria.txt_nome_cat

FROM tbl_agendamento_age as agendamento 

INNER JOIN  tbl_item_agendamento_itage as item on agendamento.num_id_age = item.tbl_agendamento_age_num_id_age
                                                                
LEFT JOIN tbl_paciente_pac paciente ON paciente.num_id_pac = agendamento.tbl_paciente_pac_num_id_pac
LEFT JOIN tbl_usuario_usu usuario ON usuario.num_id_usu = agendamento.tbl_usuario_usu_num_id_usu


LEFT JOIN tbl_procedimentos_pro procedimento ON procedimento.num_id_pro = item.tbl_procedimentos_pro_num_id_pro
LEFT JOIN tbl_categoria_cat categoria ON categoria.num_id_cat = item.tbl_categoria_cat_num_id_cat                                                                
WHERE agendamento.tbl_medico_med_num_id_med = 1 AND dta_data_age = '2024-01-05' AND hor_hora_age ='08:00:00'