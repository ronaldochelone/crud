<?php

require_once('mensagens.class.php');
class Mysql
{
    var $conect;
    var $database;
    var $query;

    //Setando os valores
    private function setReturnStatusExecuta($statusexecuta)
    {
        $this-> _statusexecuta = $statusexecuta;
    }
    private function setReturnStatusConexao($statusconexao)
    {
        $this-> _statusconexao = $statusconexao;
    }
    private function setReturnUltimoID($ultimoid)
    {
        $this-> _ultimoid = $ultimoid;
    }
    private function setReturnCountRegistro($countregistro)
    {
        $this-> _countregistro = $countregistro;
    }
    private function setReturnCountTotal($counttotal)
    {
        $this-> _counttotal = $counttotal;
    }
    private function setReturnRS($returnrs)
    {
        $this-> _returnrs = $returnrs;
    }
    private function setReturnErro($returnerro)
    {
        $this-> _returnerro = $returnerro;
    }
    private function setReturnConexao($conexao)
    {
        $this-> _conexao = $conexao;
    }
    private function setReturnHostConexao($host)
    {
        $this-> _host = $host;
    }
    private function setReturnLast_query($SQL)
    {
        $this-> _last_query = $SQL;
    }

    //Recuperando os valores
    public function getReturnStatusExecuta()
    {
        return $this-> _statusexecuta;
    }
    public function getReturnStatusConexao()
    {
        return $this-> _statusconexao;
    }
    public function getReturnUltimoID()
    {
        return $this-> _ultimoid;
    }
    public function getReturnCountRegistro()
    {
        return $this-> _countregistro;
    }
    public function getReturnCountTotal()
    {
        return $this-> _counttotal;
    }
    public function getReturnRS()
    {
        return $this-> _returnrs;
    }
    public function getReturnLogErro()
    {
        return $this-> _returnlogerro;
    }
    public function getReturnErro()
    {
        return $this-> _returnerro;
    }
    public function getReturnConexao()
    {
        return $this-> _conexao;
    }
    public function getReturnHostConexao()
    {
        return $this-> _host;
    }
    public function getReturnLast_query()
    {
        return $this-> _last_query;
    }

    function vivo($str)
    {
        echo json_encode(array('retorno' => array('status' => true,'titulo' => 'Teste','mensagem' => $str)));
        exit;
    }

    function vivo2()
    {
        echo 'OI eu aqui';
    }

    // Cria a conexão
    function Mysql($_host)
    {


        if ($_host == '') {
            $this->logErro('Não definido o tipo de conexão');
        }
        // Grava qual o tipo de conex�o est� sendo instanciado.

        $this->setReturnHostConexao($_host);
// Parametros conexão local
        if ($_host == 'local') {
            $host     = '192.168.100.202:3307';
            $db       = 'portal';
            $usuario  = 'root';
            $senha    = 'Creative22*';
        }

        /*
     // Parametros conexão AreaVip
      if($_host=='site')
        {
            $host      = 'site.mutari.com.br';
           $usuario = 'sitemutari_root';
          $senha   = 'Laforce236134';
            $db      = 'sitemutari_areavip';
       }
        */


        if ($_host == 'site') {
            $host    = '3mv.mutari.com.br';
            $db      = 'registro_sistema';
            $usuario = 'registro_sistema';
            $senha   = 'R*yeW8#fHrh';
        }

        // Parametros conexão A2
        if ($_host == 'a2') {
            $host    = '192.168.100.202:3307';
            $db      = 'sistema';
            $usuario = 'root';
            $senha   = 'Creative22*';
        }

        // Parametros conexão A2
        if ($_host == 'a2_teste') {
            $host    = '192.168.100.202:3307';
            $db      = 'sistema_teste';
            $usuario = 'root';
            $senha   = 'Creative22*';
        }

        // Parametros conexão A2 Felbi
        if ($_host == 'felbi') {
            $host    = '192.168.100.202:3307';
            $db      = 'felbi';
            $usuario = 'root';
            $senha   = 'Creative22*';
        }

        // Parametros conexão RTC
        if ($_host == 'rtc') {
            $host    = '192.168.100.202:3307';
            $db      = 'rtc2';
            $usuario = 'root';
            $senha   = 'Creative22*';
        }

        if ($_host == '3mv') {
            $host    = '3mv.mutari.com.br';
            $db      = 'registromutari_sistema';
            $usuario = 'registromutari';
            $senha   = 'R*yeW8#fHdrh';
        }

        // Parametros conexão NFE
        if (in_array($_host, array('nfe_lapeb','nfe_lob','nfe_lupe','nfe_vilfra','nfe_felbi','nfe_laforce','nfe_consulta'))) {
            $host    = '192.168.100.202:3307';
            $db      =  $_host;
            $usuario = 'root';
            $senha   = 'Creative22*';
        }

        //Executa a conexão
        $conect = mysql_connect($host, $usuario, $senha);

        // Verifica a conexão.
        if ($conect) {
            if (mysql_select_db($db, $conect)) {
                $this->setReturnConexao($conect);
                $this->setReturnStatusConexao(true);
            } else {
                $mensagem = new Mensagens();
                $this->setReturnStatusConexao(false);
                $mensagem->returnObjMensagem(1);
                exit;
            }
        } else {
            $mensagem = new Mensagens();
            $this->setReturnStatusConexao(false);
            $mensagem->returnObjMensagem(0);
            exit;
        }
    }

    // Execulta todas as SQL
    function executa($SQL)
    {


        $this->setReturnLast_query(null);

        //$this->logErro($SQL);

        // Executa as querys do sistema
        $_rs = mysql_query($SQL);

        // Verifica se a query foram executadas
        if ($_rs) {
            $this->setReturnStatusExecuta(true);
            $this->setReturnUltimoID(mysql_insert_id($this->getReturnConexao()));
            $this->setReturnRS($_rs);
            $this->setReturnCountRegistro(mysql_affected_rows($this->getReturnConexao()));
            $this->setReturnCountTotal(@mysql_result($this->getReturnRS(), 0, 'contador'));
            $this->setReturnLast_query($SQL);
        } else {
        // Retorna informando que ocorreu um erro na execu��o.
            $this->setReturnStatusExecuta(false);
            $this->setReturnErro(mysql_error());
            $this->setReturnLogErro($SQL);
        }
    }

    // Fecha a conexão
    function close()
    {

        mysql_close($this->getReturnConexao());
    }

    // Grava o log
    function setReturnLogErro($SQL)
    {
        $msg = '';
        session_start();

        $quebra = chr(13) . chr(10);
//essa � a quebra de linha

        // Mensagem
        $msg .= 'Banco:' . $this->getReturnHostConexao() . $quebra;
        $msg .= 'Pagina: ' . $_SERVER['PHP_SELF'] . $quebra;
        $msg .= 'Data Hora: ' . date('d-m-Y H:i:s') . $quebra;
        $msg .= 'Usuário: ' . $_SESSION['usuario']['nome'] . $quebra;

        if ($_SESSION['rotina'] != null || $_SESSION['rotina'] != '') {
            $msg .= 'Rotina: ' . $_SESSION['rotina'] . $quebra;
        }

        $msg .= 'Erro: ' . $this->getReturnErro() . $quebra . $quebra;
        $msg .= 'SQL: ' . $SQL . $quebra;
        $msg .= '=================================================================' . $quebra;

        // Log em Texto.
        $fp      = fopen("C:/Apache/htdocs/novoportal/log/erroExecucao.txt", "a+");
        $quebra  = chr(13) . chr(10);
        $escreve = fwrite($fp, $msg . $quebra);
        fclose($fp);
        $this->setReturnStatusConexao(false);
    }

    // Metodo que retorna um log de Erro.
    function logErro($msg)
    {


        $fp = fopen("C:/Apache/htdocs/novoportal/log/log.txt", "a+");
        $quebra = chr(13) . chr(10);
        $escreve = fwrite($fp, $msg . $quebra);
        fclose($fp);
    }

    function result_array()
    {


        if ($this->getReturnRS()) {
            mysql_data_seek($this->getReturnRS(), '0');
            while ($x = mysql_fetch_assoc($this->getReturnRS())) {
                $linhas[] = $x;
            }
            return   $linhas;
        } else {
            return array();
        }
    }

    function converteRetorno($rs, $tipo, $key)
    {


        mysql_data_seek($rs, '0');

        // JSON
        if ($tipo == 'JSON') {
            while ($x = mysql_fetch_assoc($rs)) {
                $linhas[] = $x;
            }

            if (count($linhas) == 0) {
                $linhas[] = '';
            }
            return   (json_encode($linhas));
        }

        // ARRAY SIMPLES
        if ($tipo == 'ARRAY') {
            while ($x = mysql_fetch_assoc($rs)) {
                $linhas[] = $x;
            }

            return   $linhas;
        }

        // ARRAY QUE TERÁ COMO CHAVE O KEY PASSADA POR PARAMETRO
        if ($tipo == 'ARRAY-KEY') {
            while ($x = mysql_fetch_assoc($rs)) {
                $linhas[$x[$key]] = $x;
            }
            return   $linhas;
        }
    }

    function MergeArrays($arrAux, $Arr1, $Arr2)
    {
        foreach ($Arr1 as $key => $Value) {
            if (array_key_exists($key, $arrAux) && is_array($Value)) {
                $arrAux[$key] = $this->MergeArrays($arrAux[$key], $Arr1[$key]);
            } else {
                $arrAux[$key] = $Value;
            }
        }

        foreach ($Arr2 as $key => $Value) {
            if (array_key_exists($key, $arrAux) && is_array($Value)) {
                $arrAux[$key] = $this->MergeArrays($arrAux[$key], $Arr2[$key]);
            } else {
                $arrAux[$key] = $Value;
            }
        }

        return $arrAux;
    }

    // Retorna um array com os valores de uma coluna da lista de array.
    function arrayColuna($arr = null, $coluna = null)
    {
        $arrAux = null;
        foreach ($arr as $key => $value) {
            $arrAux[] = $arr[$key][$coluna];
        }
        return $arrAux;
    }

    // Retorna o array index pela coluna informada
    // CUIDADO CASO HAJA VALORES IGUAIS SERÁ DESCARTADO VALORES IGUAIS.

    function arrayIndexadoPelaColuna($arr = null, $coluna = null)
    {
        $arrAux = null;
        foreach ($arr as $key => $value) {
            $index  = $value[$coluna];
            $arrAux[$index] = $value;
        }

        return $arrAux;
    }

    // Metodo que retorna um combobox em HTML / XML.
    function executaReturnCombobox($_tipo, $SQL, $_selec)
    {

       // Converte para utf8
        $SQL = utf8_decode($SQL);
        $this->executa("SET character_set_results=utf8");
        $this->executa($SQL);
// Numero de registros retornado na pesquisa.
        $num_registros = mysql_num_rows($this->getReturnRS());
// Retorna o nome dos campos
        $campo_value = @mysql_field_name($this->getReturnRS(), 0);
        $campo_name  = @mysql_field_name($this->getReturnRS(), 1);
// Percorre a lista de registros retornado na pesquisa.
        $op = '';

        // HTML
        if ($_tipo == 'HTML') {
            if ($num_registros > 0) {
                for ($i = 0; $i < $num_registros; $i++) {
                //Gradea o combobox.
                    if (($i % 2) != 0) {
                        $lin = "combobox-cinza";
                    } else {
                        $lin = "combobox-branco";
                    }
                    // Retorna o valor do campo
                    $value = mysql_result($this->getReturnRS(), $i, $campo_value);
                    $name  = mysql_result($this->getReturnRS(), $i, $campo_name);
                    if ($_selec == $value) {
                        $op .= '<option selected="selected" class="' . $lin . '" value="' . $value . '">' . ($name) . '</option>';
                    } else {
                        $op .= '<option  class="' . $lin . '" value="' . $value . '">' . ($name) . '</option>';
                    }
                }
            } else {
                $op .= '<option class="' . $lin . '" value="">Nenhum Registro Encontrado</option>';
            }
            return $op;
        }

        // JSON
        if ($_tipo == 'JSON') {
            $this->executa("SET character_set_results=utf8");
            $this->executa($SQL);
            mysql_data_seek($this->getReturnRS(), '0');
            while ($x = mysql_fetch_assoc($this->getReturnRS())) {
                $linhas['combobox'][] = $x;
            }
            if (count($linhas) == 0) {
                $linhas['combobox'][] = '';
            }
            return   (json_encode($linhas));
        }

        // ARRAY
        if ($_tipo == 'ARRAY') {
            $this->executa("SET character_set_results=utf8");
            $this->executa($SQL);
            mysql_data_seek($this->getReturnRS(), '0');
            while ($x = mysql_fetch_assoc($this->getReturnRS())) {
                $linhas[] = $x;
            }
            return   $linhas;
        }
    }

    function return_listaJson($key, $SQL)
    {

        $this->executa("SET character_set_results = utf8");
        $this->executa($SQL);
        mysql_data_seek($this->getReturnRS(), '0');
        while ($x = mysql_fetch_assoc($this->getReturnRS())) {
            $linhas[$key][] = $x;
        }
        if (count($linhas) == 0) {
            $linhas[$key][] = '';
        }
        return   json_encode($linhas);
    }

    function returnLista($key, $SQL, $tipo)
    {

        $this->executa("SET character_set_results = utf8");
        $this->executa($SQL);
        mysql_data_seek($this->getReturnRS(), '0');

        while ($x = mysql_fetch_assoc($this->getReturnRS())) {
            $linhas[$key][] = $x;
        }
        if (count($linhas) == 0) {
            $linhas[$key][] = '';
        }

        // Novo Array
        $newArray = array();

        foreach ($linhas as $key => $v) {
            $i = 0;
            foreach ($v as $key2 => $v2) {
                $i = 1;
                foreach ($v2 as $key3 => $v3) {
                    $newArray[$key][$key2]['coll' . $i]  = $linhas[$key][$key2][$key3];
                    $i++;
                }
            }
        }
        if ($tipo == 'JSON') {
            return json_encode($newArray);
        } elseif ($tipo == 'ARRAY') {
            return $newArray;
        } else {
            $this->logErro('Função returnLista não recebeu parametro de tipo de saida.');
        }
    }

    //-------------------------------------------------------------------------------------//
    //   Ronaldo chelone                                                                    //
    //    23-05-2016                                                                         //
    //    Novo modelo de tratamento da Class Mysql                                           //
    //-------------------------------------------------------------------------------------//

    function get_old($tabela = null, $campos = null, $condicao = null)
    {
        // Verifica se a  variavel campos é do tipo array se sim utiliza o implode se não coloca um *
        if (is_array($campos)) {
            $campos = implode(',', $campos);
        } else {
            $campos = '*';
        }

        $SQL = 'select ' . $campos . ' from ' . $tabela;

        if ($condicao != null) {
            $SQL .= ' where ';
            $i = 0;
            foreach ($condicao as $key => $value) {
                if ($i > 0) {
                            $SQL .= ' and ';
                }
                $SQL .= $key . " = '" . addslashes($value) . "'";
                $i++;
            }
        }

        $this->executa(utf8_decode($SQL));
        return $this;
    }

    function insert($tabela = null, $dados = null)
    {
        /*     Exemplo de Insert

         $dados = array('nome' => 'Renato','tipo'=>6);
           $rs = $unidade->do_insert($dados);
         echo '<br>Linhas Aferadas'.$rs->getReturnCountRegistro();
        */

        $arrValue = null;

        foreach ($dados as $key => $value) {
            $arrValue[$key] = "'" . addslashes($value) . "'";
        }

        $SQL = utf8_decode('INSERT INTO ' . $tabela . ' (' . implode(',', array_keys($arrValue)) . ') VALUE (' . implode(',', array_values($arrValue)) . ')');
        $this->executa($SQL);
        return $this;
    }

    function update($tabela = null, $dados = null, $condicao = null)
    {

        /* Exemplo de Update
          $nome       = "Fulano ' chelone á1' õ ~ ç ó : ; $%¨&*@()   ";
          $dados      =  array('nome'=>$nome,'tipo' =>5);
           $condicao   = 'id = 2';
           $rs = $unidade->do_update($dados,$condicao);
           echo '<br>Linhas Aferadas'.$rs->getReturnCountRegistro();
        */

        $SQL = 'update ' . $tabela . ' set ';
        foreach ($dados as $key => $value) {
            $SQL .= addslashes($key) . " = '" . addslashes($value) . "',";
        }

        $SQL =  substr($SQL, 0, -1) . ' where ' . $condicao;
//$this->logErro($SQL);

        $this->executa(utf8_decode($SQL));
        return $this;
    }

    function delete($tabela = null, $condicao = null)
    {

        /* Exempo de Delete
           $condicao   = 'id = 11';
           $rs = $unidade->do_delete($condicao);
          echo '<br>Linhas Aferadas'.$rs->getReturnCountRegistro();
        */


        $SQL = 'delete from ' . $tabela;
        if ($condicao != '') {
            $SQL .= ' where ' . $condicao;
        } else {
            echo 'Erro ! Necessário cláusula where para previnir apagar a tabela toda';
        }

        $this->executa(utf8_decode($SQL));
        return $this;
    }

    // Variavel.
    private $SQL                = '';
    private $table              = '';
    public $where              = '';
    public $limit              = '';
    private $fields             = array();
    private $join               = array();
    private $condition          = array();
    private $condition_in       = array();
    private $or_condition_in    = array();
    private $not_condition_in   = array();
    private $groupBy            = array();


    //--------------------------------------------------------------------------------------------//
    //                                    CONSTRUCTION                                              //
    //--------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------//
    //                                   CLEAR as SQL anteriores                                   //
    //--------------------------------------------------------------------------------------------//

    public function set_clear()
    {
        $this->SQL                  = '';
        $this->table                = '';
        $this->where                = '';
        $this->limit                = '';
        $this->fields               = array();
        $this->join                 = array();
        $this->condition            = array();
        $this->condition_in         = array();
        $this->or_condition_in      = array();
        $this->not_condition_in     = array();
        $this->groupBy              = array();
    }

    //--------------------------------------------------------------------------------------------//
    //                                 CONSTANT DO WHERE                                         //
    //--------------------------------------------------------------------------------------------//
    public function set_consts_where()
    {
        $this->where = ' where ';
    }

    public function get_consts_where()
    {
        return $this->where;
    }

    //--------------------------------------------------------------------------------------------//
    //                                              TABLE                                         //
    //--------------------------------------------------------------------------------------------//
    public function set_table($table = null)
    {
        if ($table != null) {
            $this->table = $table;
        }
    }

    public function get_table()
    {
        return  $this->table;
    }

    //--------------------------------------------------------------------------------------------//
    //                                             FIELDS                                        //
    //--------------------------------------------------------------------------------------------//

    public function set_fields($fields = null)
    {
        if ($fields != null) {
            if (is_array($fields)) {
                foreach ($fields as $key => $value) {
                    $this->fields[] = $value;
                }
            } else {
                $this->fields[] = $fields;
            }
        }
    }

    public function get_fields()
    {
        $fields = $this->fields;

        if (count($fields) < 1) {
            return '*';
        } else {
            return implode(',', $fields);
        }
    }

    //--------------------------------------------------------------------------------------------//
    //                                             JOIN                                          //
    //--------------------------------------------------------------------------------------------//

    public function set_join($table = null, $condition = null, $direction = null)
    {


        if ($table != null && $condition != null && $direction != null) {
            $this->join[] = array($table,$condition,$direction);
        }
    }

    public function get_join()
    {


        $join = $this->join;
        $sql = '';
        foreach ($join as $key => $value) {
            $sql .= $join[$key][2] . ' join ' . $join[$key][0] . ' on ( ' . $join[$key][1] . ' )';
        }
        return $sql ;
    }

    //--------------------------------------------------------------------------------------------//
    //                                               WHERE                                         //
    //--------------------------------------------------------------------------------------------//

    public function set_where($condition = null)
    {
        if ($condition != null) {
            $this->set_consts_where();

            if (is_array($condition)) {
                foreach ($condition as $key => $value) {
                    $this->condition[] = array($key,$value);
                }
            } else {
                $this->condition[] = $condition;
            }
        }
    }

    public function get_where()
    {


        $condition  = $this->condition;
        $sql        = '';
        $i          = 0;

        foreach ($condition as $key => $value) {
            if ($i > 0) {
                $sql .= ' and ';
            }

            if (is_array($value)) {
                // Pesquisa para saber se existe algum dos operadores abaixo
                // se sim não coloca operador padrão "="
                $a = array(' is ','=','<','>','<=','>=','<>','!=');

                $char = false;
                foreach ($a as $key2 => $value2) {
                    if (strpos($value[0], $value2) > -1) {
                        $char  = true;
                        break;
                    }
                }

                if (!$char) {
                    $operador = ' = ';
                } else {
                    $operador = '';
                }

                $sql .= $value[0] . $operador . '"' . $value[1] . '"';
            } else {
                $sql .=  $value;
            }
            $i++;
        }

        return $sql;
    }

    //--------------------------------------------------------------------------------------------//
    //                                               WHERE IN                                      //
    //--------------------------------------------------------------------------------------------//


    public function set_where_in($fields = null, $condition = null)
    {
        if ($condition != null && $fields != null) {
            $this->set_consts_where();
            if (is_array($condition)) {
                foreach ($condition as $key => $value) {
                    $this->condition_in[] = array($key,implode(',', $value));
                }
            } else {
                $condition = explode(',', $condition);
                foreach ($condition as $key => $value) {
                    $condition[$key] = '"' . $value . '"';
                }

                $this->condition_in[] = array($fields,implode(',', $condition));
            }
        }
    }

    public function get_where_in()
    {
        $condition_in = $this->condition_in;
        $sql = '';
        $i = 0;

        foreach ($condition_in as $key => $value) {
            if ($i > 0) {
                $sql .= ' and ';
            }

            if (is_array($value)) {
                $sql .= $value[0] . ' in (' . $value[1] . ')';
            }

            $i++;
        }

        return $sql;
    }

    //--------------------------------------------------------------------------------------------//
    //                                           OR WHERE IN                                       //
    //--------------------------------------------------------------------------------------------//

    public function set_or_where_in($fields = null, $condition = null)
    {
        if ($condition != null && $fields != null) {
            if (is_array($condition)) {
                foreach ($condition as $key => $value) {
                    $this->or_condition_in[] = array($key,implode(',', $value));
                }
            } else {
                $condition = explode(',', $condition);
                foreach ($condition as $key => $value) {
                    $condition[$key] = '"' . $value . '"';
                }

                $this->or_condition_in[] = array($fields,implode(',', $condition));
            }
        }
    }

    public function get_or_where_in()
    {
        $or_condition_in = $this->or_condition_in;
        $sql = '';
        $i = 0;

        foreach ($or_condition_in as $key => $value) {
            if ($i > 0) {
                $sql .= ' or ';
            }

            if (is_array($value)) {
                $sql .= $value[0] . ' in (' . $value[1] . ')';
            }

            $i++;
        }
        return $sql;
    }

    //--------------------------------------------------------------------------------------------//
    //                                            NOT WHERE IN                                      //
    //--------------------------------------------------------------------------------------------//

    public function set_where_not_in($fields = null, $condition = null)
    {

        if ($condition != null && $fields != null) {
            if (is_array($condition)) {
                $this->not_condition_in[] = array($fields,implode(',', $condition));
            } else {
                $this->not_condition_in[] = array($fields,$condition);
            }
        }
    }

    public function get_where_not_in()
    {
        $not_condition_in = $this->not_condition_in;
        $sql = '';
        $i = 0;

        foreach ($not_condition_in as $key => $value) {
            if ($i > 0) {
                $sql .= ' and ';
            }

            if (is_array($value)) {
                $sql .= $value[0] . ' not in (' . $value[1] . ')';
            }

            $i++;
        }
        return $sql;
    }

    //--------------------------------------------------------------------------------------------//
    //                                        WHERE BETWEEN                                         //
    //--------------------------------------------------------------------------------------------//

    public function set_where_between($fields = null, $parameter1 = null, $parameter2 = null)
    {
        if ($fields != null && $parameter1 != null && $parameter2 != null) {
            $this->set_consts_where();
            $this->condition_between[] = array($fields,$parameter1,$parameter2);
        }
    }

    public function get_where_between()
    {
        $condition_between = $this->condition_between;
        $sql = '';
        $i = 0;

        foreach ($condition_between as $key => $value) {
            if ($i > 0) {
                $sql .= ' and ';
            }
            $sql .= $value[0] . ' between "' . $value[1] . '" and "' . $value[2] . '"';
            $i++;
        }

        return $sql;
    }

    //--------------------------------------------------------------------------------------------//
    //                                       ORDER BY                                              //
    //--------------------------------------------------------------------------------------------//

    public function set_order($order = null)
    {
        if ($order != null) {
            if (is_array($order)) {
                foreach ($order as $key => $value) {
                    if ($order[$key] != '') {
                        $order[$key] = ' ' . $order[$key];
                    }
                    $this->order[] = $key . $order[$key];
                }
            } else {
                $this->order[] = $order;
            }
        }
    }

    public function get_order()
    {
        $order = $this->order;

        $sql = '';
        $i = 0;
        foreach ($order as $key => $value) {
            if ($i > 0) {
                $sql .= ',';
            }
            $sql .= $value;

            $i++;
        }

        return $sql;
    }

    //--------------------------------------------------------------------------------------------//
    //                                       GROUP BY                                              //
    //--------------------------------------------------------------------------------------------//

    public function set_groupBy($group = null)
    {
        if ($group != null) {
            if (is_array($group)) {
                foreach ($group as $key => $value) {
                    if ($group[$key] != '') {
                        $group[$key] = ' ' . $group[$key];
                    }
                    $this->groupBy[] = $group[$key];
                }
            } else {
                $this->groupBy[] = $group;
            }
        }
    }

    public function get_groupBy()
    {
        $groupBy = $this->groupBy;

        $sql = '';
        $i = 0;

        foreach ($groupBy as $key => $value) {
            if ($i > 0) {
                $sql .= ',';
            }
            $sql .= $value;

            $i++;
        }

        return $sql;
    }

    //--------------------------------------------------------------------------------------------//
    //                                       LIMIT                                                 //
    //--------------------------------------------------------------------------------------------//

    public function set_limit($begin = null, $end = null)
    {
        if (($begin != null) && ($end != null)) {
            $this->limit = ' limit ' . $begin . ',' . $end;
        }
    }

    public function get_limit()
    {

        return  $this->limit;
    }

    public function get($table = null)
    {


        if ($table != null) {
            $this->set_table($table);
        }

        $SQL  = 'select ' . $this->get_fields();
        $SQL .= ' from ' . $this->get_table();
        $SQL .= ' ' . $this->get_join();
        $SQL .= ' ' . $this->get_consts_where();
        $SQL .= ' ' . $this->get_where();
        if ($this->get_where() != '' && $this->get_where_in() != '') {
            $SQL .= ' and ';
        }
        $SQL .= ' ' . $this->get_where_in();
        if ($this->get_where() != '' && $this->get_or_where_in() != '') {
            $SQL .= ' or ';
        }
        $SQL .= ' ' . $this->get_or_where_in();
        if ($this->get_where() != '' && $this->get_where_not_in() != '') {
            $SQL .= ' and ';
        }
        $SQL .= ' ' . $this->get_where_not_in();
        if ($this->get_where() != '' && $this->get_where_between() != '') {
            $SQL .= ' and ';
        }
        $SQL .= ' ' . $this->get_where_between();
        if ($this->get_groupBy() != '') {
            $SQL .= ' group by ';
        }
        $SQL .= ' ' . $this->get_groupBy();
        if ($this->get_order() != '') {
            $SQL .= ' order by ';
        }
        $SQL .= ' ' . $this->get_order();

        if ($this->get_limit() != '') {
            $SQL .= $this->get_limit();
        }


        $this->executa($SQL);
    }

    public function getSQL()
    {


        $SQL  = 'select ' . $this->get_fields();
        $SQL .= ' from ' . $this->get_table();
        $SQL .= ' ' . $this->get_join();
        $SQL .= ' ' . $this->get_consts_where();
        $SQL .= ' ' . $this->get_where();

        if ($this->get_where() != '' && $this->get_where_in() != '') {
            $SQL .= ' and ';
        }
        $SQL .= ' ' . $this->get_where_in();
        if ($this->get_where() != '' && $this->get_or_where_in() != '') {
            $SQL .= ' or ';
        }
        $SQL .= ' ' . $this->get_or_where_in();
        if ($this->get_where() != '' && $this->get_where_not_in() != '') {
            $SQL .= ' and ';
        }
        $SQL .= ' ' . $this->get_where_not_in();
        if ($this->get_where() != '' && $this->get_where_between() != '') {
            $SQL .= ' and ';
        }
        $SQL .= ' ' . $this->get_where_between();
        if ($this->get_groupBy() != '') {
            $SQL .= ' group by ';
        }
        $SQL .= ' ' . $this->get_groupBy();
        if ($this->get_order() != '') {
            $SQL .= ' order by ';
        }
        $SQL .= ' ' . $this->get_order();
        if ($this->get_limit() != '') {
            $SQL .= $this->get_limit();
        }
        return  $SQL;
    }
}
