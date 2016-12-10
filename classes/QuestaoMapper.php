<?php

    /**
    * Mapper da entidade Questao
    */
    class QuestaoMapper
    {
        private $id_questao;
        private $descricao_questao;
        private $id_questionario;

        public function __construct($pdo) {
            $this->pdo = $pdo;
        }

        public function __destruct() {
            $this->pdo = null;
        }

        public function setDescricao($descricao) {
            $this->descricao_questao = $descricao;
        }

        public function getIdQuestao() {
            return $this->id_questao;
        }

        public function getDescricao() {
            return $this->descricao_questao;
        }

        public function getQuestoes($params) {

            $obj = $this->pdo->prepare('
                SELECT id_questao, descricao_questao, id_questionario
                FROM Questao '.$this->getWhere($params),
                array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY)
            );

            if ($params != null) {
                $obj->execute($params);
            } else {
                $obj->execute();
            }

            $result = $obj->fetchAll();
            $obj = null;

            return $result;
        }

        public function saveQuestao($params) {

            if(array_key_exists("id_questao", $params)) {
                $obj = $this->pdo->prepare("UPDATE Questao
                                                                SET descricao_questao = :descricao_questao
                                                                WHERE id_questao = :id_questao",
                                                                array(':descricao_questao' => $params['descricao_questao'],
                                                                          ':id_questao' => $params['id_questao'])
                                                                );
            }
            else {
                $obj = $this->pdo->prepare("INSERT INTO Questao (id_questionario, descricao_questao)
                                                                VALUES (:id_questionario, :descricao_questao)",
                                                                array(':id_questionario' => $params['id_questionario'],
                                                                          ':descricao_questao' => $params['descricao_questao'])
                                                                );
            }
            $obj->execute($params);

            try {
                $message = array("message" => "", "type" => "SUCESS", "code" => 200);
            }
            catch(Exception $e) {
                $message = array("message" => $e->getMessage(), "type" => "ERROR", "code" => 400);
            }

            $obj = null;

            return $message;
        }

        private function getWhere($params) {

            $result = null;

            if (array_key_exists(":id_questao", $params)) {
                $result = 'WHERE id_questao= :id_questao';
            }
            elseif (array_key_exists(":id_questionario", $params)) {
                $result = 'WHERE id_questionario = :id_questionario';
            }

            return $result;
        }
    }