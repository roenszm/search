<?php
/**
 * Created by PhpStorm.
 * User: roens
 * Date: 2015/8/4
 * Time: 17:54
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /Index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */

    public function __construct() {
        parent::__construct();

    }
    public function index() {
        $data['active_navbar'] = "navbar-main";
        $data['search_url'] = "www.iqiyi.com";      //此处写上你的网址
        $this->load->view('main/index',$data);
    }

    public function search() {
        $url = $this->input->get("url");
        $search = $this->input->get("file");
        if ($search == "") {
            $data["error"] = "search file is needed.";
            echo json_encode($data);
            return ;
        }
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        $pattern = "/<[^<>]+".$search."[^<>]+>/";           //确保搜索的文件名处于一个标签内，若需求有变请自行修改
        $times = preg_match_all($pattern, $output, $matches);

        $data["output"] = $output;
        $data["times"] = $times;
        $data["matches"] = $matches;
        echo json_encode($data);

    }
}
