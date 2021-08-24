<?php
    class InvalidFloorException extends Exception{
        public function _construct($floor = 1){
            $floor = $floor ?: 1;
            parent::_construct($floor);
        }
    }

    class UpdateException extends Exception{
        public function _construct($dbquery = FALSE){
            $db->query($sql) $dbquery ?: FALSE;
            parent::_construct($message);
        }
    }

    class IvalidUserTypeException extends Exception{
        public function _construct($stud_fac){
            $stud_fac = $stud_fac ?: 0;
            parent::_construct($stud_fac);
        }
    }
?>