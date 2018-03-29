<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tag extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('posts');
	}

	public function index()
	{
		$data['title']="Daftar Tag";
		$data['tags'] = $this->posts->getalltags('tags');
		$data['file']="tags/alltags";
		$data['status'] = 'baru';
		$data['idtag'] = '';
		$data['tag'] = '';
		$this->load->view('table_template',$data);
	}

	public function save()
	{
		if ($_POST) {
			$status = $this->input->post('status');
			if ($status == 'baru') {
				$data['tag'] = $this->input->post('tag');
				$result = $this->posts->savetag('tags',$data);
				if ($result == 1) {
					$this->session->set_flashdata("sukses", "<div class='alert alert-success'><strong>Berhasil Tambah Tag</strong></div>");
					header('location:'.base_url().'tag');
				}
			}else{
				$id = $this->input->post('idtag');
				$data ['tag'] = $this->input->post('tag');
				$result = $this->posts->updatetag('tags', $data, $id);
				if ($result) {
					$this->session->set_flashdata("sukses", "<div class='alert alert-success'><strong>Berhasil Update Tag</strong></div>");
					header('location:'.base_url().'tag');
				}
			}
		}
	}

	public function edit($id = '')
	{
		$tampung = $this->posts->gettagbyid('tags',$id);
		$data = array(
			'title' => "Daftar Tag",
			'status' => 'lama',
			'file' => 'tags/alltags',
			'tag' => $tampung[0]['tag'],
			'idtag' => $tampung[0]['idtag'],
			'tags' => $this->posts->getalltags('tags')
		);
		$this->load->view('table_template',$data);
	}

	public function delete($id = '')
	{
		$this->posts->deletetag('posts_tags',$id);
		$this->posts->deletetag('tags',$id);
		
		$this->session->set_flashdata("sukses", "<div class='alert alert-success'><strong>Berhasil Hapus Tag</strong></div>");
		header('location:'.base_url().'tag');
		
	}

}

/* End of file Tag.php */
/* Location: ./application/controllers/Tags.php */