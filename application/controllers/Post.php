<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Post extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('posts');
		$this->load->model('datamedia');
	}

	public function index()
	{
		$data['title']="Semua Pos";
		$data['file']="posts/allpost";
		$data['posts'] = $this->posts->getposts(); 
		$this->load->view('table_template',$data);
	}

	public function view($id = '')
	{
		$data['post'] = $this->posts->getpostbyid('posts',$id);
		$data['categories'] = $this->posts->categories_post($id);
		$data['tags'] = $this->posts->tags_post($id);
		$data['file']="posts/show";
		$this->load->view('form_template',$data);
	}

	public function add()
	{
		$data['title']="Tambah Pos";
		$data['file']="posts/addpost";
		$data['categories'] = $this->posts->getallcategories('categories');
		$data['tags'] = $this->posts->getalltags('tags');
		$this->load->view('form_template',$data);
	}


	public function save()
	{
		$slug = url_title($this->input->post('title'));

		$tags = $this->input->post('tags');
		$categories = $this->input->post('category');

		$datetime = date('Y-m-d H:i:s');

		$idpost = uniqid();

		$action = $this->input->get_post("actionbtn");
		$status ='';

		if ($action == 'terbit') {
			$status = '1';
			$sess = $this->session->set_flashdata("sukses", "<div class='alert alert-success'><strong>Pos Telah Terbit</strong></div>");
		}else if($action == 'konsep'){
			$status = '2';
			$sess = $this->session->set_flashdata("sukses", "<div class='alert alert-success'><strong>Post Disimpan Di Konsep</strong></div>");
		}

		$data = array(
			'idpost' => $idpost,
			'title' => $this->input->post('title'),
			'content' => $this->input->post('content'),
			'featured_image' => 'image.jpg',
			'date_published' => $datetime,
			'slug' => $slug,
			'post_status' => $status,
			'iduser' => 3
		);
		$this->posts->savepost('posts',$data);

		foreach ($tags as $tag) {
			$data = array(
				'idpost' => $idpost,
				'idtag' => $tag
			);
			$this->posts->savepost('posts_tags', $data);

		}

		foreach ($categories as $category) {
			
			$data = array(
				'idpost' => $idpost,
				'idcategory' => $category
			);
			$this->posts->savepost('categories_detail', $data);

		}
		
		$sess;
		redirect('posts-all');


	}

	public function edit($id='')
	{

		$data['post'] = $this->posts->getpostbyid('posts',$id);
		$data['c'] = $this->posts->categories_post($id);
		$data['t'] = $this->posts->tags_post($id);

		$data['media'] = $this->datamedia->list_image();
		$data['title']="Edit Pos";
		$data['file']="posts/editpost";
		$data['categories'] = $this->posts->getallcategories('categories');
		$data['tags'] = $this->posts->getalltags('tags');
		$this->load->view('form_template',$data);
	}

	public function update()
	{
		$id = $this->input->post('id');

		$slug = url_title($this->input->post('title'));

		$tags = $this->input->post('tags');
		$categories = $this->input->post('category');

		$datetime = date('Y-m-d H:i:s');

		$action = $this->input->get_post("actionbtn");
		$status ='';

		if ($action == 'terbit') {
			$status = '1';
			$sess = $this->session->set_flashdata("sukses", "<div class='alert alert-success'><strong>Pos Telah Terbit</strong></div>");
		}else if($action == 'konsep'){
			$status = '2';
			$sess = $this->session->set_flashdata("sukses", "<div class='alert alert-success'><strong>Post Disimpan Di Konsep</strong></div>");
		}

		$data = array(
			'title' => $this->input->post('title'),
			'content' => $this->input->post('content'),
			'featured_image' => 'image.jpg',
			'date_published' => $datetime,
			'slug' => $slug,
			'post_status' => $status,
			'iduser' => 3
		);
		$this->posts->updatepost('posts',$data,$id);

		$this->posts->deletepost('posts_tags',$id);
		$this->posts->deletepost('categories_detail',$id);


		foreach ($tags as $tag) {
			$data = array(
				'idpost' => $id,
				'idtag' => $tag
			);
			$this->posts->savepost('posts_tags', $data);

		}

		foreach ($categories as $category) {
			
			$data = array(
				'idpost' => $id,
				'idcategory' => $category
			);
			$this->posts->savepost('categories_detail', $data);

		}
		$sess;
		redirect('posts-all');

		


	}
	public function delete($id= '')
	{
		$this->posts->deletepost('posts_tags',$id);
		$this->posts->deletepost('categories_detail',$id);
		$this->posts->deletepost('posts',$id);

		$this->session->set_flashdata("sukses", "<div class='alert alert-success'><strong>Post Berhasil Dihapus</strong></div>");
		redirect('posts-all');
	}

	// get media JSON

	public function mediajson()
	{
		$data = $this->posts->mediajson();
		echo json_encode($data);
	}

}