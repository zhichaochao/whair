<?php
class ControllerCommonFooter extends Controller {
	public function index() {
		$this->load->language('common/footer');

		$data['text_footer'] = sprintf($this->language->get('text_footer'), $_SERVER['SERVER_NAME']);
		
		return $this->load->view('common/footer', $data);
	}
}
