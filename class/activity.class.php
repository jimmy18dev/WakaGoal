<?php
class Activity{

    public function __construct() {
        global $wpdb;
        $this->db = $wpdb;
    }

    public function add($user_id,$language,$total_seconds,$day){
        if($this->hasActivity($user_id,$language,$day)){
            $this->db->query('INSERT INTO activity(user_id,language,total_seconds,day) VALUE(:user_id,:language,:total_seconds,:day)');
            $this->db->bind(':user_id',$user_id);
            $this->db->bind(':language',$language);
            $this->db->bind(':total_seconds',$total_seconds);
            $this->db->bind(':day',$day);
            $this->db->execute();
            $user_id = $this->db->lastInsertId();
            return $user_id;
        }
    }

    public function Yesterday($user_id){
        $this->db->query('SELECT SUM(total_seconds) total_seconds FROM activity WHERE user_id = :user_id AND day = :yesterday');
        $this->db->bind(':user_id',$user_id);
        $this->db->bind(':yesterday',date('Y-m-d',strtotime("-1 days")));
        $this->db->execute();
        $dataset = $this->db->single();

        $dataset['text'] = $this->db->secondsText($dataset['total_seconds']);

        return $dataset;
    }
    public function ThisWeek($user_id){
        $this->db->query('SELECT SUM(total_seconds) total_seconds FROM activity WHERE user_id = :user_id AND YEARWEEK(day, 1) = YEARWEEK(CURDATE(),1)');
        $this->db->bind(':user_id',$user_id);
        $this->db->execute();
        $dataset = $this->db->single();

        $dataset['text'] = $this->db->secondsText($dataset['total_seconds']);

        return $dataset;
    }
    public function ThisMonth($user_id){
        $this->db->query('SELECT SUM(total_seconds) total_seconds FROM activity WHERE user_id = :user_id AND MONTH(day) = MONTH(CURRENT_DATE()) AND YEAR(day) = YEAR(CURRENT_DATE())');
        $this->db->bind(':user_id',$user_id);
        $this->db->execute();
        $dataset = $this->db->single();

        $dataset['text'] = $this->db->secondsText($dataset['total_seconds']);

        return $dataset;
    }

    public function listActivity($user_id){
        $this->db->query('SELECT * FROM activity WHERE user_id = :user_id ORDER BY day ASC');
        $this->db->bind(':user_id',$user_id);
        $this->db->execute();
        $response = $this->db->resultset();

        $dataset    = [];

        // Restructure from Date
        foreach ($response as $k => $v){
            $date = $v['day'];

            if(!in_array($date, array_column($dataset,'date'))){
                $structure = array(
                    'date'          => $date,
                    'activity'      => []
                );

                array_push($dataset,$structure);
            }

            $pos = array_search($date, array_column($dataset,'date'));

            $subset = array(
                'language'      => $response[$k]['language'],
                'total_seconds' => floatval($response[$k]['total_seconds']),
            );

            array_push($dataset[$pos]["activity"],$subset);
        }

        // Cal Total Seconds
        foreach ($dataset as $k => $v) {
            $dataset[$k]['total_seconds']   = floatval(array_sum(array_column($v['activity'],'total_seconds')));
            $dataset[$k]['text']            = $this->db->secondsText($dataset[$k]['total_seconds']); 
            $dataset[$k]['date_text']       = $this->db->datetimeformat($dataset[$k]['date']); 
        }

        return $dataset;
    }

    public function hasActivity($user_id,$language,$day){
        $this->db->query('SELECT id FROM activity WHERE user_id = :user_id AND language = :language AND day = :day');
        $this->db->bind(':user_id',$user_id);
        $this->db->bind(':language',$language);
        $this->db->bind(':day',$day);
        $this->db->execute();
        $dataset = $this->db->single();

        if(empty($dataset['id']) || $dataset['id'] == 0)
            return true;
        else
            return false;
    }

    public function languageOfMonth($user_id){
        $this->db->query('SELECT SUM(total_seconds) total_seconds,language FROM activity WHERE user_id = :user_id AND MONTH(day) = MONTH(CURRENT_DATE()) AND YEAR(day) = YEAR(CURRENT_DATE()) GROUP BY language ORDER BY total_seconds DESC');
        $this->db->bind(':user_id',$user_id);
        $this->db->execute();
        $dataset = $this->db->resultset();

        foreach ($dataset as $k => $v) {
            $dataset[$k]['text'] = $this->db->secondsText($dataset[$k]['total_seconds']);
        }

        return $dataset;
    }

    public function leaderboards(){
        $this->db->query('SELECT SUM(total_seconds) total_seconds,user_id,user.name,user.photo,day FROM activity LEFT JOIN user AS user ON user_id = user.id GROUP BY day,user_id ORDER BY day DESC');
        $this->db->bind(':user_id',$user_id);
        $this->db->execute();
        $response = $this->db->resultset();

        $dataset    = [];

        // Restructure from Date
        foreach ($response as $k => $v){
            $date = $v['day'];

            if(!in_array($date, array_column($dataset,'date'))){
                $structure = array(
                    'date'          => $date,
                    'activity'      => []
                );

                array_push($dataset,$structure);
            }

            $pos = array_search($date, array_column($dataset,'date'));

            $subset = array(
                'username'      => $response[$k]['name'],
                'photo'      => $response[$k]['photo'],
                'total_seconds' => floatval($response[$k]['total_seconds']),
                'text' => $this->db->secondsText($response[$k]['total_seconds'])
            );

            array_push($dataset[$pos]["activity"],$subset);
        }

        // Cal Total Seconds
        foreach ($dataset as $k => $v) {
            $dataset[$k]['date_text'] = $this->db->datetimeformat($dataset[$k]['date']);
        }

        return $dataset;
    }
}
?>