<?php //Star date
/*
        $dateStart = '2023-12-18';
        $dateStart 		= new DateTime($dateStart);
        $dateEnd = '2023-12-22';
        $dateEnd 		= new DateTime($dateEnd);

        include_once "conexao.php";
        
        //Prints days according to the interval
        /*$dateRange = array();
        while($dateStart <= $dateEnd){            

            $dateRange[] = $dateStart->format('Y-m-d');

            $dateStart->format('Y-m-d').'###';

                $dia = $dateStart->format('Y-m-d');	
                $res = $con->prepare("SELECT count(dta_data_age) as 'qtd', dta_data_age FROM tbl_agendamento_age where dta_data_age = ? ");

                $res->bindParam(1,$dia);
                $res->execute();

                while ($row = $res->fetch(PDO::FETCH_OBJ)){
                    echo $dia;
                    ECHO '<br>';
                    echo $row->qtd;
                    ECHO '<br>';
                }
                
            
            $dateStart = $dateStart->modify('+1day');
        }*/
        
        //var_dump($dateRange);

        $dateStart = '08:00:00';
        $dateStart 		= new DateTime($dateStart);
        $dateEnd = '12:00:00';
        $dateEnd 		= new DateTime($dateEnd);

        $dateRange = array();
        while($dateStart <= $dateEnd){            

            $dateRange[] = $dateStart->format('H:m:s');

            $dateStart->format('H:m:s').'###';

                echo $dia = $dateStart->format('H:m:s');	
                $res = $con->prepare("SELECT * FROM tbl_agendamento_age where hor_hora_age = ? ");

                $res->bindParam(1,$dia);
                $res->execute();

                while ($row = $res->fetch(PDO::FETCH_OBJ)){
                    echo $dia;
                    echo $row->num_id_age;
                    echo $row->tbl_paciente_pac_num_id_pac;
                    ECHO '<br>';
                }
                
            
            $dateStart = $dateStart->modify('+1 hours');
        }

        ?>