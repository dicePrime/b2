<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Commons;

/**
 * Description of Tools
 *
 * @author BMHB8456
 */
class Tools {

    //put your code here
    public static $_MONTHS = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
    public static $_MONTHS_BY_INDEX = array('01' => "Jan", "02" => "Fev", "03" => "Mar",
        "04" => "Avr", "05" => "Mai", "06" => "Jun", "07" => "Juil", "08" => "Aou", "09" => "Sep",
        "10" => "Oct", "11" => "Nov", "12" => "Dec");
    public static $_PERIODE = array('201401', '201402', '201403', '201404', '201405',
        '201406', '201407', '201408', '201409', '201410',
        '201411', '201412', '201501', '201502', '201503',
        '201504', '201505', '201506', '201507', '201508',
        '201509', '201510', '201511', '201512', '201601',
        '201602', '201603', '201604', '201605', '201606',
        '201607', '201608', '201609', '201610', '201611',
        '201612');
    public static $_MAX_EXCEL_SHEET_ROWS = 10000;

    public static function writeFile($fileLocation, $text) {
        $monfichier = fopen($fileLocation, "w");
        fputs($monfichier, print_r($text, true));
        fclose($monfichier);
    }

    public static function addComment($oldComment, $newComment, $date, $author) {
        if ($newComment != null) {
            $newString = $author . ";;" . $newComment . ";;" . $date . ";;;";

            if ($oldComment == null) {
                $resultat = $newString;
            } else {
                $resultat = $oldComment . $newString;
            }

            return $resultat;
        } else {
            return $oldComment;
        }
    }

    /**
     * SQL Like operator in PHP.
     * Returns TRUE if match else FALSE.
     * @param string $pattern
     * @param string $subject
     * @return bool
     */
    public static function like_match($pattern, $subject) {
        $pattern = str_replace('%', '.*', preg_quote($pattern, '/'));
        return (bool) preg_match("/^{$pattern}$/i", $subject);
    }

    public static function commentsToArray($commentsString) {

        $resultat = array();
        if ($commentsString != null) {

            $chaineCommentaires = preg_split("#;;;#", $commentsString);


            foreach ($chaineCommentaires as $next) {
                $newCommentString = preg_split("#;;#", $next);

                if (count($newCommentString) > 2) {
                    $newComment = array(
                        'nom' => $newCommentString[0],
                        'commentaire' => $newCommentString[1],
                        'date' => $newCommentString[2]
                    );
                    $resultat[] = $newComment;
                }
            }
        }


        return $resultat;
    }
        
}
