<?php

    /**
    * Mapper da entidade Conselho de Classe
    */
    class ConselhoMapper
    {
        private $id_conselho;
        private $descricao_conselho;

        public function __construct($pdo) {
            $this->pdo = $pdo;
        }

        public function __destruct() {
            $this->pdo = null;
        }

        public function setDescricao($descricao) {
            $this->descricao_conselho = $descricao;
        }

        public function getId() {
            return $this->id_conselho;
        }

        public function getDescricao() {
            return $this->descricao_conselho;
        }

        public function getConselhos() {
            $obj = $this->pdo->prepare('
                SELECT * FROM ConselhoClasse',
                array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY)
            );

            $obj->execute();

            $result = $obj->fetchAll();
            $obj = null;

            return $result;
        }
    }