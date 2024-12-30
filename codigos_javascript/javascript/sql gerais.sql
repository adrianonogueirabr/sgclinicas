detalhes de pacientes

SELECT paciente.num_id_pac, categoria.txt_nome_cat, usuario_cadastro.txt_login_usu, profissao.txt_nome_pro,
                paciente.txt_nome_pac, paciente.txt_cpf_pac, paciente.txt_cor_pac, paciente.txt_sexo_pac, paciente.dta_datanascimento_pac, paciente.txt_naturalidade_pac, 
                paciente.txt_email_pac, paciente.txt_telefone_pac, paciente.txt_senha_pac, paciente.txt_estadocivil_pac, paciente.txt_cep_pac, paciente.txt_logradouro_pac, 
                paciente.num_numero_pac, paciente.txt_complemento_pac, paciente.txt_bairro_pac, paciente.txt_cidade_pac, paciente.txt_estado_pac, paciente.txt_dificuldade_pac,
                paciente.txt_observacoes_pac, paciente.txt_matricula_pac, paciente.val_saldo_pac, paciente.dta_registro_pac,usuario_alteracao.txt_login_usu, 
                paciente.dth_alteracao_pac, paciente.dta_ultimavisita_pac, paciente.txt_ativo_pac 
        
            FROM tbl_paciente_pac paciente
            
            LEFT JOIN tbl_categoria_cat categoria on paciente.tbl_categoria_cat_num_id_cat  = categoria.num_id_cat 
            LEFT JOIN tbl_profissao_pro profissao on paciente.tbl_profissao_pro_num_id_pro  = profissao.num_id_pro 
            LEFT JOIN tbl_usuario_usu usuario_cadastro on paciente.tbl_usuario_usu_num_id_usu  = usuario_cadastro.num_id_usu 
            LEFT JOIN tbl_usuario_usu usuario_alteracao on paciente.num_usuario_alteracao_pac  = usuario_alteracao.num_id_usu
            
            WHERE paciente.num_id_pac = :num_id_pac LIMIT 1

SELECT tbl_paciente_pac.num_id_pac, tbl_paciente_pac.tbl_categoria_cat_num_id_cat, tbl_paciente_pac.tbl_usuario_usu_num_id_usu, tbl_paciente_pac.tbl_profissao_pro_num_id_pro,
                tbl_paciente_pac.txt_nome_pac, tbl_paciente_pac.txt_cpf_pac, tbl_paciente_pac.txt_cor_pac, tbl_paciente_pac.txt_sexo_pac, tbl_paciente_pac.dta_datanascimento_pac, tbl_paciente_pac.txt_naturalidade_pac, 
                tbl_paciente_pac.txt_email_pac, tbl_paciente_pac.txt_telefone_pac, tbl_paciente_pac.txt_senha_pac, tbl_paciente_pac.txt_estadocivil_pac, tbl_paciente_pac.txt_cep_pac, tbl_paciente_pac.txt_logradouro_pac, 
                tbl_paciente_pac.num_numero_pac, tbl_paciente_pac.txt_complemento_pac, tbl_paciente_pac.txt_bairro_pac, tbl_paciente_pac.txt_cidade_pac, tbl_paciente_pac.txt_estado_pac, tbl_paciente_pac.txt_dificuldade_pac,
                tbl_paciente_pac.txt_observacoes_pac, tbl_paciente_pac.txt_matricula_pac, tbl_paciente_pac.val_saldo_pac, tbl_paciente_pac.dta_registro_pac,tbl_paciente_pac.num_usuario_alteracao_pac, 
                tbl_paciente_pac.dth_alteracao_pac, tbl_paciente_pac.dta_ultimavisita_pac, tbl_paciente_pac.txt_ativo_pac 

                FROM tbl_paciente_pac

                WHERE tbl_paciente_pac.num_id_pac = 1 LIMIT 1


                <div class="col-md-4">
                                <label for="inputNatural" class="form-label">Naturalidade</label>
                                <select id="inputNatural" class="form-select" name="inputNatural">
                                    <option value="">SELECIONE</option>
                                    <OPTION VALUE="MANAUS">MANAUS</OPTION>
                                    <OPTION VALUE="PARINTINS">PARINTINS</OPTION>
                                    <OPTION VALUE="ITACOATIARA">ITACOATIARA</OPTION>
                                    <OPTION VALUE="MANACAPURU">MANACAPURU</OPTION>
                                    <OPTION VALUE="COARI">COARI</OPTION>
                                    <OPTION VALUE="TABATINGA">TABATINGA</OPTION>
                                    <OPTION VALUE="MAUES">MAUÉS</OPTION>
                                    <OPTION VALUE="TEFE">TEFÉ</OPTION>
                                    <OPTION VALUE="MANICORE">MANICORÉ</OPTION>
                                    <OPTION VALUE="HUMAITA">HUMAITÁ</OPTION>
                                    <OPTION VALUE="IRANDUBA">IRANDUBA</OPTION>
                                    <OPTION VALUE="LABREA">LÁBREA</OPTION>
                                    <OPTION VALUE="SAO GABRIEL DA CACHOEIRA">SÃO GABRIEL DA CACHOEIRA</OPTION>
                                    <OPTION VALUE="BENJAMIN CONSTANT">BENJAMIN CONSTANT</OPTION>
                                    <OPTION VALUE="BORBA">BORBA</OPTION>
                                    <OPTION VALUE="AUTAZES">AUTAZES</OPTION>
                                    <OPTION VALUE="SAO PAULO DE OLIVENCA">SÃO PAULO DE OLIVENÇA</OPTION>
                                    <OPTION VALUE="CAREIRO">CAREIRO</OPTION>
                                    <OPTION VALUE="NOVA OLINDA DO NORTE">NOVA OLINDA DO NORTE</OPTION>
                                    <OPTION VALUE="PRESIDENTE FIGUEIREDO">PRESIDENTE FIGUEIREDO</OPTION>
                                    <OPTION VALUE="EIRUNEPE">EIRUNEPÉ</OPTION>
                                    <OPTION VALUE="BOCA DO ACRE">BOCA DO ACRE</OPTION>
                                    <OPTION VALUE="RIO PRETO DA EVA">RIO PRETO DA EVA</OPTION>
                                    <OPTION VALUE="MANAQUIRI">MANAQUIRI</OPTION>
                                    <OPTION VALUE="BARREIRINHA">BARREIRINHA</OPTION>
                                    <OPTION VALUE="CAREIRO DA VÁRZEA">CAREIRO DA VÁRZEA</OPTION>
                                    <OPTION VALUE="IPIXUNA">IPIXUNA</OPTION>
                                    <OPTION VALUE="CODAJAS">CODAJÁS</OPTION>
                                    <OPTION VALUE="CARAUARI">CARAUARI</OPTION>
                                    <OPTION VALUE="BARCELOS">BARCELOS</OPTION>
                                    <OPTION VALUE="SANTA ISABEL DO RIO NEGRO">SANTA ISABEL DO RIO NEGRO</OPTION>
                                    <OPTION VALUE="NOVO ARIPUANA">NOVO ARIPUANÃ</OPTION>
                                    <OPTION VALUE="URUCURITUBA">URUCURITUBA</OPTION>
                                    <OPTION VALUE="APUI">APUÍ</OPTION>
                                    <OPTION VALUE="ANORI">ANORI</OPTION>
                                    <OPTION VALUE="NHAMUNDA">NHAMUNDÁ</OPTION>
                                    <OPTION VALUE="SANTO ANTONIO DO ICA">SANTO ANTÔNIO DO IÇÁ</OPTION>
                                    <OPTION VALUE="ATALAIA DO NORTE">ATALAIA DO NORTE</OPTION>
                                    <OPTION VALUE="ENVIRA">ENVIRA</OPTION>
                                    <OPTION VALUE="BERURI">BERURI</OPTION>
                                    <OPTION VALUE="NOVO AIRAO">NOVO AIRÃO</OPTION>
                                    <OPTION VALUE="BOA VISTA DO RAMOS">BOA VISTA DO RAMOS</OPTION>
                                    <OPTION VALUE="PAUINI">PAUINI</OPTION>
                                    <OPTION VALUE="TONANTINS">TONANTINS</OPTION>
                                    <OPTION VALUE="MARAA">MARAÃ</OPTION>
                                    <OPTION VALUE="GUAJARA">GUAJARÁ</OPTION>
                                    <OPTION VALUE="TAPAUA">TAPAUÁ</OPTION>
                                    <OPTION VALUE="FONTE BOA">FONTE BOA</OPTION>
                                    <OPTION VALUE="ALVARAES">ALVARÃES</OPTION>
                                    <OPTION VALUE="URUCARA">URUCARÁ</OPTION>
                                    <OPTION VALUE="CANUTAMA">CANUTAMA</OPTION>
                                    <OPTION VALUE="JURUA">JURUÁ</OPTION>
                                    <OPTION VALUE="SAO SEBASTIAO DO UATUMA">SÃO SEBASTIÃO DO UATUMÃ</OPTION>
                                    <OPTION VALUE="ANAMA">ANAMÃ</OPTION>
                                    <OPTION VALUE="UARINI">UARINI</OPTION>
                                    <OPTION VALUE="CAAPIRANGA">CAAPIRANGA</OPTION>
                                    <OPTION VALUE="JUTAI">JUTAÍ</OPTION>
                                    <OPTION VALUE="AMATURA">AMATURÁ</OPTION>
                                    <OPTION VALUE="ITAPIRANGA">ITAPIRANGA</OPTION>
                                    <OPTION VALUE="SILVES">SILVES</OPTION>
                                    <OPTION VALUE="ITAMARATI">ITAMARATI</OPTION>
                                    <OPTION VALUE="JAPURA">JAPURÁ</OPTION>
                                    <OPTION VALUE="OUTROS">OUTROS</OPTION>
                                </select>
                            </div>

                
                