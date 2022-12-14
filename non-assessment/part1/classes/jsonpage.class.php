<?php
/**
 * Creates a JSON page based on the parameters
 *
 * @author YOUR NAME
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
            case 'films':
                $this->page = $this->json_films();
                break;
            case 'login':
                $this->page = $this->json_login();
                break;
            case 'update':
                $this->page = $this->json_update();
                break;
            case 'actors':
                $this->page = $this->json_actors();
                break;
            default:
                $this->page = $this->json_error();
                break;
        }
    }

    //an arbitrary max length of 20 is set
    private function sanitiseString($x) {
        return substr(trim(filter_var($x, FILTER_SANITIZE_STRING)), 0, 20);
    }

    //an arbitrary max range of 1000 is set
    private function sanitiseNum($x) {
        return filter_var($x, FILTER_VALIDATE_INT, array("options"=>array("min_range"=>0, "max_range"=>1000)));
    }

    private function json_welcome() {
        $msg = array("message"=>"welcome", "author"=>"Sean Pattinson");
        return json_encode($msg);
    }

    private function json_error() {
        $msg = array("message"=>"error");
        return json_encode($msg);
    }

    private function json_authors() {
        $query  = "SELECT name FROM authors";
        $params = [];

        if (isset($_REQUEST['search'])) {
            $query .= " WHERE name LIKE :term";
            $term = $this->sanitiseString("%".$_REQUEST['search']."%");
            $params = ["term" => $term];
        } else {
            if (isset($_REQUEST['id'])) {
                $query .= " WHERE authorId LIKE :id";
                $term = $this->sanitiseNum($_REQUEST['id']);
                $params = ["id" => $term];
            }

            if(isset($_REQUEST['limit'])) {
                $query .= " ORDER BY name";
                $query .= " LIMIT :limit ";
                $term = $this->sanitiseNum($_REQUEST['limit']);
                $params = ['limit' => $term];
            }

            if (isset($_REQUEST['page'])) {
                $query .= " ORDER BY name";
                $query .= " LIMIT 10 ";
                $query .= " OFFSET ";
                $query .= 10 * ($this->sanitiseNum($_REQUEST['page'])-1);
            }
        }

        return ($this->recordset->getJSONRecordSet($query, $params));
    }

    private function json_rooms() {
        $query  = "SELECT name FROM rooms";
        $params = [];

        if (isset($_REQUEST['search'])) {
            $query .= " WHERE name LIKE :term";
            $term = $this->sanitiseString("%".$_REQUEST['search']."%");
            $params = ["term" => $term];
        } else {
            if (isset($_REQUEST['id'])) {
                $query .= " WHERE roomId LIKE :id";
                $term = $this->sanitiseNum($_REQUEST['id']);
                $params = ["id" => $term];
            }

            if(isset($_REQUEST['limit'])) {
                $query .= " ORDER BY name";
                $query .= " LIMIT :limit ";
                $term = $this->sanitiseNum($_REQUEST['limit']);
                $params = ['limit' => $term];
            }

            if (isset($_REQUEST['page'])) {
                $query .= " ORDER BY name";
                $query .= " LIMIT 10 ";
                $query .= " OFFSET ";
                $query .= 10 * ($this->sanitiseNum($_REQUEST['page'])-1);
            }
        }

        return ($this->recordset->getJSONRecordSet($query, $params));
    }

    /**
     * json_login
     *
     * @todo this method can be improved
     */
    private function json_login() {
        $msg = "Invalid request. Username and password required";
        $status = 400;
        $token = null;
        $input = json_decode(file_get_contents("php://input"));

        if ($input) {

            if (isset($input->email) && isset($input->password)) {
                $query  = "SELECT firstname, lastname, password, admin FROM users WHERE email LIKE :email";
                $params = ["email" => $input->email];
                $res = json_decode($this->recordset->getJSONRecordSet($query, $params),true);
                $password = ($res['count']) ? $res['data'][0]['password'] : null;

                if (password_verify($input->password, $password)) {
                    $msg = "User authorised. Welcome ". $res['data'][0]['firstname'] . " " . $res['data'][0]['lastname'];
                    $status = 200;
                    $token = array();
                    $token['email'] = $input->email;
                    $token['firstname'] = $res['data'][0]['firstname'];
                    $token['lastname'] = $res['data'][0]['lastname'];
                    $token['iat'] = time();
                    $token['exp'] = time(); //+ 1*60*60;
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
            return json_encode(array("status" => 400, "message" => "Invalid request"));
        }
        if (!isset($input->token)) {
            return json_encode(array("status" => 401, "message" => "Not authorised"));
        }
        if (!isset($input->description) || !isset($input->film_id)) {
            return json_encode(array("status" => 400, "message" => "Invalid request"));
        }

        try {
            $jwtkey = JWTKEY;
            $tokenDecoded = \Firebase\JWT\JWT::decode($input->token, $jwtkey, array('HS256'));
        }
        catch (UnexpectedValueException $e) {
            return json_encode(array("status" => 401, "message" => $e->getMessage()));
        }

        $query  = "UPDATE film SET description = :description WHERE film_id = :film_id";
        $params = ["description" => $input->description, "film_id" => $input->film_id];
        //$res = $this->recordset->getJSONRecordSet($query, $params);
        return json_encode(array("status" => 200, "message" => "ok"));
    }

    /**
     * json_films
     *
     * @todo this function can be improved
     */
    private function json_films() {
        $query  = "SELECT film.film_id, film.title, film.description, film.rating, language.name AS language, film.length, category.name AS category FROM film JOIN language on (language.language_id = film.language_id) JOIN category on (category.category_id = film.category_id) ";
        $params = [];
        $where = " WHERE ";
        $doneWhere = FALSE;

        if (isset($_REQUEST['actor_id'])) {
            $query .= " INNER JOIN film_actor on 
     (film.film_id = film_actor.film_id)
     INNER JOIN actor on 
     (film_actor.actor_id = actor.actor_id) ";

            $where .= " actor.actor_id = :actor_id ";
            $doneWhere = TRUE;
            $term = $this->sanitiseNum($_REQUEST['actor_id']);
            $params["actor_id"] = $term;
        }

        if (isset($_REQUEST['search'])) {
            $doneWhere ? $where .= " AND " : $doneWhere = TRUE;

            $where .= " title LIKE :search";
            $term = $this->sanitiseString("%".$_REQUEST['search']."%");
            $params["search"] = $term;
        }
        if (isset($_REQUEST['id'])) {
            $doneWhere ? $where .= " AND " : $doneWhere = TRUE;

            $where .= " film_id = :film_id ";
            $term = $this->sanitiseNum($_REQUEST['id']);
            $params["film_id"] = $term;
        }

        $query .= $doneWhere ? $where : "";

        $nextpage = null;

        // @todo - this assumes a page should contain 10 items, but this is not consistent with the client
        if (isset($_REQUEST['page'])) {
            $query .= " ORDER BY film_id";
            $query .= " LIMIT 10 ";
            $query .= " OFFSET ";
            $query .= 10 * ($this->sanitiseNum($_REQUEST['page'])-1);
            $nextpage = BASEPATH."api/films?page=".$this->sanitiseNum($_REQUEST['page']+1);
        }

        // This decodes the JSON encoded by getJSONRecordSet() from an associative array
        // @todo - A recordset method that returns an associative array might be more appropriate
        $res = json_decode($this->recordset->getJSONRecordSet($query, $params),true);

        $res['status'] = 200;
        $res['message'] = "ok";
        $res['next_page'] = $nextpage;
        return json_encode($res);
    }

    private function json_actors() {
        $query  = "SELECT actor_id, first_name, last_name FROM actor";
        $params = [];

        if (isset($_REQUEST['search'])) {
            $query .= " WHERE last_name LIKE :term";
            $term = $this->sanitiseString("%".$_REQUEST['search']."%");
            $params = ["term" => $term];
        } else {
            if (isset($_REQUEST['id'])) {
                $query .= " WHERE actor_id LIKE :id";
                $term = $this->sanitiseNum($_REQUEST['id']);
                $params = ["id" => $term];
            }

            if(isset($_REQUEST['limit'])) {
                $query .= " ORDER BY actor_id";
                $query .= " LIMIT :limit ";
                $term = $this->sanitiseNum($_REQUEST['limit']);
                $params = ['limit' => $term];
            }

            if (isset($_REQUEST['page'])) {
                $query .= " ORDER BY actor_id";
                $query .= " LIMIT 10 ";
                $query .= " OFFSET ";
                $query .= 10 * ($this->sanitiseNum($_REQUEST['page'])-1);
            }
        }

        return ($this->recordset->getJSONRecordSet($query, $params));
    }

    public function get_page() {
        return $this->page;
    }
}
?>