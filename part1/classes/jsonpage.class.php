<?php
/**
 * Creates a JSON page based on the parameters
 *
 * Provides a JSON response with recordset as data upon calling of the
 * specified endpoints can.
 *
 *
 * This class has been tested on PHP 5.6 and all Functions/Methods
 * work as intended
 *
 * @author Sean pattinson
 *
 *
 *
 */
class JSONpage {
    private $page;
    private $recordset;

    /**
     * @param $pathArr - an array containing the route information
     */
    public function __construct($pathArr, $recordset) {
        $this->recordset = $recordset;
        $path = (empty($pathArr[1])) ? "api" : $pathArr[1];

        switch ($path) {
            case 'api':
                $this->page = $this->json_welcome();
                break;
            case 'authors':
                $this->page = $this->json_authors();
                break;
            case 'login':
                $this->page = $this->json_login();
                break;
            case 'update':
                $this->page = $this->json_update();
                break;
            case 'sessions':
                $this->page = $this->json_sessions();
                break;
            case 'sessions_authors':
                $this->page = $this->json_sessions_authors();
                break;
            case 'slots':
                $this->page = $this->json_slots();
                break;
            case 'content':
                $this->page = $this->json_content();
                break;
            case 'chairs':
                $this->page = $this->json_chairs();
                break;
            default:
                $this->page = $this->json_error();
                break;
        }
    }

    /**
     * A sample function docblock
     * @global string document the fact that this function uses $_myvar
     * @staticvar integer $staticvar this is actually what is returned
     * @param string $param1 name to declare
     * @param string $param2 value of the name
     * @return integer
     */
    private function sanitiseString($x) {
        return substr(trim(filter_var($x, FILTER_SANITIZE_STRING)), 0, 20);
    }

    private function sanitiseNum($x) {
        return filter_var($x, FILTER_VALIDATE_INT, array("options"=>array("min_range"=>0, "max_range"=>1000000)));
    }

    /**
     * @return json encoded message with information about the API
     */
    private function json_welcome() {
        $msg = array("message"=>"welcome", "author"=>"Sean Pattinson", "about" => "This API was developed as part of university coursework and is not affiliated or associated with CHI in anyway nor any of its sponsors.");
        return json_encode($msg);
    }

    private function json_error() {
        $msg = array("message"=>"You have reached an invalid endpoint please make sure you have tried to access a valid endpoint.");
        return json_encode($msg);
    }

    private function json_authors() {
        $query  = "SELECT authors.authorId as author_id, authors.name as name FROM authors";
        $params = [];

        if (isset($_REQUEST['content_id'])) {
            $query .= ' JOIN content_authors ON (content_authors.authorId=authors.authorId) JOIN content on (content.contentId=content_authors.contentId)';
            $query .= " WHERE content.contentId = :content_id";
            $term = $this->sanitiseNum(intval($_REQUEST['content_id']));
            $params = ["content_id" => $term];
        }

        if (isset($_REQUEST['search'])) {
            $query .= " WHERE name LIKE :term";
            $term = $this->sanitiseString("%".$_REQUEST['search']."%");
            $params = ["term" => $term];
        } else {
            if (isset($_REQUEST['id'])) {
                $query .= " WHERE authorId = :id";
                $term = $this->sanitiseNum(intval($_REQUEST['id']));
                $params = ["id" => $term];
            }
        }

        return ($this->recordset->getJSONRecordSet($query, $params));
    }

    /**
     * json_films
     *
     * @todo this function can be improved
     */
    private function json_content() {
        $query  = "select content.contentId as contentId, content.title as title, content.abstract as abstract, content.award as award";
        $joins = ' FROM content';
        $params = [];
        $where = " WHERE ";
        $doneWhere = FALSE;
        $groupBy = " GROUP BY ";
        $group = FALSE;


        if (isset($_REQUEST['session_id'])) {
            $query .= ', sessions.name as session';
            $joins .= ' JOIN sessions_content on (sessions_content.contentId=content.contentId) 
                        JOIN sessions on (sessions.sessionId=sessions_content.sessionId)';
            $where .= " sessions_content.sessionId = :session_id ";
            $doneWhere = TRUE;
            $term = $this->sanitiseNum($_REQUEST['session_id']);
            $params["session_id"] = $term;
            $groupBy .= ' content.contentId';
            $group = TRUE;
        }

        if (isset($_REQUEST['content_id'])) {
            $doneWhere ? $where .= " AND " : $doneWhere = TRUE;

            $where .= " content.contentId LIKE :content_id";
            $term = $this->sanitiseString("%".$_REQUEST['content_id']."%");
            $params["content_id"] = $term;
        }

        if (isset($_REQUEST['search'])) {
            $doneWhere ? $where .= " AND " : $doneWhere = TRUE;

            $where .= " session LIKE :search";
            $term = $this->sanitiseString("%".$_REQUEST['search']."%");
            $params["search"] = $term;
        }
        if (isset($_REQUEST['author_id'])) {
            $doneWhere ? $where .= " AND " : $doneWhere = TRUE;
            $where .= " authors.authorId = :author_id ";
            $query.= ', authors.name as author';
            $joins .= ' join content_authors on (content_authors.contentId=content.contentId) 
                        join authors on (authors.authorId=content_authors.authorId)';
            $term = $this->sanitiseNum($_REQUEST['author_id']);
            $params["author_id"] = $term;
        }
        $query .= $joins;
        $query .= $doneWhere ? $where : "";
        $query.= $group ? $groupBy : "";

        try {
            $res = json_decode($this->recordset->getJSONRecordSet($query, $params), true);
            if (isset($params['content_id'])) {
                $authors = [];
                foreach ($res['data'] as $key) {
                    $author = $key['author'];
                    $authors[] = array('name' => $author);
                }
                $res['data'][0]['authors'] = $authors;
            }

        }
        catch (UnexpectedValueException $e) {
            return json_encode(array("status" => 401, "message" => $e->getMessage()));
        }

        $res['status'] = 200;
        $res['message'] = "ok";
        return json_encode($res);
    }

    private function json_chairs() {
        $query  = "SELECT authors.name, sessions.sessionId as session FROM sessions JOIN authors on (authors.authorId = sessions.chairId)";
        $params = [];

            if (isset($_REQUEST['session_id'])) {
                $query .= " WHERE sessions.sessionId = :session_id";
                $term = $this->sanitiseNum(intval($_REQUEST['session_id']));
                $params = ["session_id" => $term];
            }

        return ($this->recordset->getJSONRecordSet($query, $params));
    }

    /**
     * json_login
     *
     * @return JSON encoded array depending on outcome of function
     */
    private function json_login() {
        $msg = "Invalid request. Username and password required";
        $status = 400;
        $token = null;
        $input = json_decode(file_get_contents("php://input"));

        if ($input) {

            if (isset($input->email) && isset($input->password)) {
                $query  = "SELECT username, password, admin FROM users WHERE email LIKE :email";
                $params = ["email" => $input->email];
                $res = json_decode($this->recordset->getJSONRecordSet($query, $params),true);
                $password = ($res['count']) ? $res['data'][0]['password'] : null;

                if (password_verify($input->password, $password)) {
                    $msg = "User authorised. Welcome ". $res['data'][0]['username'];
                    $status = 200;
                    $token = array();
                    $token['email'] = $input->email;
                    $token['name'] = $res['data'][0]['username'];
                    $token['iat'] = time();
                    $token['exp'] = time() + 1*60*60;
                    $token['admin'] = $res['data'][0]['admin'];
                    $jwtkey = JWTKEY;
                    $token = Firebase\JWT\JWT::encode($token, $jwtkey);
                } else {
                    $msg = "username or password are invalid";
                    $status = 401;
                }
            }
        }

        return json_encode(array("status" => $status, "message" => $msg, "token" => $token));
    }

    /**
     * json_update
     *
     * @todo this method can be improved
     */
    private function json_update() {
        $input = json_decode(file_get_contents("php://input"));

        if (!$input) {
            return json_encode(array("status" => 400, "message" => "Invalid request", "input" => $input));
        }
        if (!isset($input->token)) {
            return json_encode(array("status" => 401, "message" => "Not authorised"));
        }
        if (!isset($input->description) || !isset($input->session_id)) {
            return json_encode(array("status" => 400, "message" => "Invalid request", "input" => $input));
        }
            try {
                $jwtkey = JWTKEY;
                $tokenDecoded = array();
                $tokenDecoded = \Firebase\JWT\JWT::decode($input->token, $jwtkey, array('HS256'));
            } catch (UnexpectedValueException $e) {
                return json_encode(array("status" => 401, "message" => $e->getMessage()));
            }

        if (intval($tokenDecoded->admin) === 1 && $tokenDecoded->exp > time()) {
            $query  = "UPDATE sessions SET name = :name WHERE sessionId = :session_id";
            $params = ["name" => $input->description, "session_id" => $input->session_id];
            $res = $this->recordset->getJSONRecordSet($query, $params);
        } else {
            return json_encode(array("status" => 401, "message" => "Not authorised"));
        }


        return json_encode(array("status" => 200, "message" => "ok"));
    }

    private function json_sessions() {
        $query  = "SELECT sessions.name as session, rooms.name as room, sessions.sessionId as session_id from sessions JOIN rooms on (rooms.roomId=sessions.roomId)";
        $params = [];
        $where = " WHERE ";
        $doneWhere = FALSE;


        if (isset($_REQUEST['author_id'])) {

            $where .= " authors.authorId = :author_id ";
            $doneWhere = TRUE;
            $term = $this->sanitiseNum($_REQUEST['author_id']);
            $params["author_id"] = $term;
        }

        if (isset($_REQUEST['search'])) {
            $doneWhere ? $where .= " AND " : $doneWhere = TRUE;

            $where .= " session LIKE :search";
            $term = $this->sanitiseString("%".$_REQUEST['search']."%");
            $params["search"] = $term;
        }
        if (isset($_REQUEST['id'])) {
            $doneWhere ? $where .= " AND " : $doneWhere = TRUE;

            $where .= " sessionId = :session_id ";
            $term = $this->sanitiseNum($_REQUEST['id']);
            $params["session_id"] = $term;
        }

        if (isset($_REQUEST['slot_id'])) {
            $doneWhere ? $where .= " AND " : $doneWhere = TRUE;

            $where .= " sessions.slotId = :slot_id ";
            $term = $this->sanitiseNum($_REQUEST['slot_id']);
            $params["slot_id"] = $term;
        }

        if (isset($_REQUEST['dayNo'])) {
            $doneWhere ? $where .= " AND " : $doneWhere = TRUE;

            $where .= " slots.dayInt = :dayNo";
            $term = $this->sanitiseNum($_REQUEST['dayNo']);
            $params["dayNo"] = $term;
        }

        $query .= $doneWhere ? $where : "";
        $nextpage = null;

        try {
            $res = json_decode($this->recordset->getJSONRecordSet($query, $params), true);
        }
        catch (UnexpectedValueException $e) {
            return json_encode(array("status" => 401, "message" => $e->getMessage()));
        }

        $res['status'] = 200;
        $res['message'] = "ok";
        $res['next_page'] = $nextpage;
        return json_encode($res);
    }

    private function json_slots() {
        $query = "SELECT slots.slotId, slots.dayString, slots.startHour, slots.startMinute, slots.endHour, slots.endMinute FROM slots";
        $params = [];
        $where = " WHERE ";
        $doneWhere = FALSE;

        if (isset($_REQUEST['dayString'])) {
            $where .= " slots.dayString like :dayString";
            $doneWhere=TRUE;
            $term = $this->sanitiseString("%".$_REQUEST['dayString']."%");
            $params["dayString"] = $term;
        }

        if (isset($_REQUEST['slot_id'])) {
            $doneWhere ? $where .= " AND " : $doneWhere = TRUE;
            $query .= " INNER JOIN sessions on (sessions.slotId=slots.slotId)";

            $where .= " sessions.slotId = :slot_id";
            $term = $this->sanitiseNum($_REQUEST['slot_id']);
            $params["slot_id"] = $term;
        }

        if (isset($_REQUEST['search'])) {
            $query .= " WHERE last_name LIKE :term";
            $term = $this->sanitiseString("%".$_REQUEST['search']."%");
            $params = ["term" => $term];
        } else {
            if (isset($_REQUEST['dayNo'])) {
                $query .= " WHERE slots.dayInt = :day";
                $term = $this->sanitiseNum($_REQUEST['dayNo']);
                $params = ["day" => $term];
            }

            $query .= $doneWhere ? $where : "";
            $nextpage = null;
        }

        return ($this->recordset->getJSONRecordSet($query, $params));
    }

    private function json_sessions_authors() {
        $query = "select authors.authorId as authorId, authors.name as name, sessions.name as session, content.title as title, content.abstract as abstract, content.contentId as contentId
                    from sessions 
                    join sessions_content on (sessions_content.sessionId=sessions.sessionId) 
                    JOIN content on (content.contentId=sessions_content.contentId) 
                    JOIN content_authors on (content_authors.contentId=content.contentId) 
                    join authors on (authors.authorId=content_authors.authorId) ";
        $params = [];
        $where = " WHERE ";
        $doneWhere = FALSE;

        if (isset($_REQUEST['slot_id'])) {
            $query .= " INNER JOIN slots on (slots.slotId=sessions.slotId)";

            $where .= " sessions.slotId = :slot_id ";
            $doneWhere = TRUE;
            $term = $this->sanitiseNum($_REQUEST['slot_id']);
            $params["slot_id"] = $term;
        }

        if (isset($_REQUEST['search'])) {
            $query .= " WHERE last_name LIKE :term";
            $term = $this->sanitiseString("%".$_REQUEST['search']."%");
            $params = ["term" => $term];
        } else {
            if (isset($_REQUEST['author_id'])) {
                $doneWhere ? $where .= " AND " : $doneWhere = TRUE;
                $where .= " authors.authorId = :author_id";
                $term = $this->sanitiseNum($_REQUEST['author_id']);
                $params = ["author_id" => $term];
            }

            $query .= $doneWhere ? $where : "";

            $nextpage = null;
        }

        return ($this->recordset->getJSONRecordSet($query, $params));
    }

    public function get_page() {
        return $this->page;
    }
}
?>