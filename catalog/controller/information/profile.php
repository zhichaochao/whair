<?php
class ControllerInformationProfile extends Controller {
	public function index() {
				$this->load->language('information/profile');

				$this->load->model('catalog/profile');
					$this->load->model('tool/image');
				$this->document->setTitle($this->language->get('heading_title'));
				$profile_parent=$this->model_catalog_profile->getProfiles(0);
				// print_r($profile_parent);exit;
				foreach ($profile_parent as $key => $profiles) {
					   $data['profiles'][$key] = $profiles;
					   $data['profiles'][$key]['child'] = $this->model_catalog_profile->getProfiles($profiles['profile_id']);
					}
				$profile_par['profiles']=$profile_parent;
				 $data['profile_id']=$profile_par['profiles'][0]['profile_id'];
				 $data['profiles_id']=$profile_par['profiles'][1]['profile_id'];
				// var_dump($data['profile_id']);die;
				$profile_care=$this->model_catalog_profile->getProfile($data['profile_id']);
				//print_r($profile_care);exit;
				$childs=$this->model_catalog_profile->getProfiles($data['profile_id'],3);
				//print_r($childs);exit;
				if ($childs) {
						foreach ($childs as $key => $value) {
							$childs[$key]['href']=$this->url->link('information/profile/infocare', 'profile_id=' .  $value['profile_id']);
							$childs[$key]['image']=$this->model_tool_image->resize($value['image'],380,350);
							$childs[$key]['images']=$this->model_tool_image->resize($value['images'],920,460);
						}
				}
				$profile_care['childs']=$childs;

				$profile_know=$this->model_catalog_profile->getProfile( $data['profiles_id']);
				$childs=$this->model_catalog_profile->getProfiles( $data['profiles_id'],3);
					if ($childs) {
				
						foreach ($childs as $key => $value) {
							$childs[$key]['href']=$this->url->link('information/profile/infoknow', 'profile_id=' .  $value['profile_id']);
							$childs[$key]['image']=$this->model_tool_image->resize($value['image'],380,350);
							$childs[$key]['images']=$this->model_tool_image->resize($value['images'],920,460);
						}
				}
				$profile_know['childs']=$childs;
				// print_r($profile_care['childs']);exit;
				$videos=$this->model_catalog_profile->getVideos(array('start'=>0,'limit'=>3));
				//var_dump($videos);exit;
			    if ($videos) {
				
						foreach ($videos as $key => $value) {
							//$videos[$key]['video']=HTTP_SERVERS. $value['video'];
							$videos[$key]['video']=HTTPS_SERVERS.'/image/video/hairclub/'. $value['video'];
							$videos[$key]['title']=$value['title'];
							$videos[$key]['image']=$this->model_tool_image->resize($value['image'],380,215);
						}
				}
			   $profile_video['videos']=$videos;
//var_dump($profile_video['videos']);exit;
				$data['breadcrumbs'] = array();

				$data['breadcrumbs'][] = array(
					'text' => $this->language->get('text_home'),
					'href' => $this->url->link('common/home')
				);
				$data['profile_care']=$profile_care;
				$data['profile_know']=$profile_know;
				$data['profile_video']=$profile_video;
				$data['videohome'] = $this->url->link('information/profile/hairclub', '', true);
				$data['column_left'] = $this->load->controller('common/column_left');
				//$data['column_right'] = $this->load->controller('common/column_right');
				$data['account_left'] = $this->load->controller('account/left');      //新左侧栏
				$data['content_top'] = $this->load->controller('common/content_top');
				//$data['content_bottom'] = $this->load->controller('common/content_bottom');
				$data['footer'] = $this->load->controller('common/footer');
				$data['header'] = $this->load->controller('common/header');
	
			$this->response->setOutput($this->load->view('information/profile_index', $data));
		}
		public function hairclub()
		{
				$this->load->language('information/profile');
				$this->document->setTitle($this->language->get('heading_titles'));
				$this->load->model('catalog/profile');
					$this->load->model('tool/image');
			  $url = '';
			   if (isset($this->request->get['page'])) {
				$page = $this->request->get['page'];
			} else {
				$page = 1;
			}
			if (isset($this->request->get['limit'])) {
			$limit = (int)$this->request->get['limit'];
			} else {
				$limit = 9;
			}
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
			$product_total = $this->model_catalog_profile->getVideoCount();
			//print_r($product_total);exit();
			$pagination = new Pagination();
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->url = $this->url->link('information/profile/hairclub',  $url . '&page={page}');
			//print_r($pagination->limit);exit();
			$data['pagination'] = $pagination->render();
			$filter_data = array(
				'start'              => ($page - 1) * $limit,
				'limit'              => $limit
			);
				$videos=$this->model_catalog_profile->getVideos($filter_data);
				//var_dump($videos);exit;
				if ($videos) {
				
						foreach ($videos as $key => $value) {
							// $videos[$key]['video']=HTTP_SERVERS. $value['video'];
							$videos[$key]['video']=HTTPS_SERVERS.'/image/video/hairclub/'. $value['video'];
							$videos[$key]['title']=$value['title'];
							$videos[$key]['image']=$this->model_tool_image->resize($value['image'],380,215);
						}
				}
			// $data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));
			// print_r($data['results']);exit();
			if ($page == 1) {
			    $this->document->addLink($this->url->link('information/profile/hairclub', '', true), 'canonical');
			} elseif ($page == 2) {
			    $this->document->addLink($this->url->link('information/profile/hairclub', '', true), 'prev');
			} else {
			    $this->document->addLink($this->url->link('information/profile/hairclub', $url . '&page='. ($page - 1), true), 'prev');
			}

			if ($limit && ceil($product_total / $limit) > $page) {
			    $this->document->addLink($this->url->link('information/profile/hairclub', $url . '&page='. ($page + 1), true), 'next');
			}
			$data['allpage']=ceil($product_total / $limit);
 			 $profile_video['videos']=$videos;
			   $data['profile_video']=$profile_video;

			$data['column_left'] = $this->load->controller('common/column_left');
				//$data['column_right'] = $this->load->controller('common/column_right');
				$data['account_left'] = $this->load->controller('account/left');      //新左侧栏
				$data['content_top'] = $this->load->controller('common/content_top');
				//$data['content_bottom'] = $this->load->controller('common/content_bottom');
				$data['footer'] = $this->load->controller('common/footer');
				$data['header'] = $this->load->controller('common/header');
	
			$this->response->setOutput($this->load->view('information/hairhome', $data));
		}
		public function infocare()
		{
				$this->load->model('catalog/profile');
				$this->load->model('tool/image');
				$this->load->language('information/profile');
				$this->document->setTitle($this->language->get('heading_title'));
				$profile_info=$this->model_catalog_profile->getProfile($this->request->get['profile_id']);
				if ($profile_info['video_ids']) {
						$http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
					$videos=$this->model_catalog_profile->getProfileVideos($profile_info['video_ids']);
					// print_r($videos);exit();
					foreach ($videos as $key => $value) {
							// $videos[$key]['video']=HTTP_SERVERS. $value['video'];
							$videos[$key]['video']=HTTPS_SERVERS.'/image/video/hairclub/'. $value['video'];
							$videos[$key]['title']=$value['title'];
							$videos[$key]['image']=$this->model_tool_image->resize($value['image'],380,215);
					}
					$data['videos']=$videos;
				}else{
					$data['videos']=array();
				}
				//print_r($profile_info);exit;
				$this->model_catalog_profile->updateProfileView($this->request->get['profile_id']);
				$data['author']=$profile_info['author'];
				$data['view']=$profile_info['view'];
				$data['title']=$profile_info['title'];
				$data['update_time']=$profile_info['update_time'];
				//$data['image']=$this->model_tool_image->resize($profile_info['image'],920,460);
				$data['images']=$this->model_tool_image->resize($profile_info['images'],920,460);

				$data['column_left'] = $this->load->controller('common/column_left');
				$data['description'] = html_entity_decode($profile_info['description'], ENT_QUOTES, 'UTF-8');
				$data['account_left'] = $this->load->controller('account/left');      //新左侧栏
				$data['content_top'] = $this->load->controller('common/content_top');
				$data['footer'] = $this->load->controller('common/footer');
				$data['header'] = $this->load->controller('common/header');
			$this->response->setOutput($this->load->view('information/profile_care', $data));
		}
		public function infoknow()
		{
				$this->load->model('catalog/profile');
				$this->load->model('tool/image');
				$this->load->language('information/profile');
				$this->document->setTitle($this->language->get('heading_title'));
				$profile_info=$this->model_catalog_profile->getProfile($this->request->get['profile_id']);
				$this->model_catalog_profile->updateProfileView($this->request->get['profile_id']);
				$data['author']=$profile_info['author'];
				$data['view']=$profile_info['view'];
				$data['title']=$profile_info['title'];
				$data['update_time']=$profile_info['update_time'];
				//$data['image']=$this->model_tool_image->resize($profile_info['image'],920,460);
				$data['images']=$this->model_tool_image->resize($profile_info['images'],920,460);

				$data['column_left'] = $this->load->controller('common/column_left');
				$data['description'] = html_entity_decode($profile_info['description'], ENT_QUOTES, 'UTF-8');
				$data['account_left'] = $this->load->controller('account/left');      //新左侧栏
				$data['content_top'] = $this->load->controller('common/content_top');
				$data['footer'] = $this->load->controller('common/footer');
				$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('information/profile_know', $data));
		} 
		public function loadpage()
		{
				$this->load->language('information/profile');
				$this->document->setTitle($this->language->get('heading_titles'));
				$this->load->model('catalog/profile');
					$this->load->model('tool/image');
			$http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
			  $url = '';
			   if (isset($this->request->get['page'])) {
				$page = $this->request->get['page'];
			} else {
				$page = 1;
			}
			if (isset($this->request->get['limit'])) {
			$limit = (int)$this->request->get['limit'];
			} else {
				$limit = 9;
			}
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
			$product_total = $this->model_catalog_profile->getVideoCount();
			//print_r($product_total);exit();
			$pagination = new Pagination();
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->url = $this->url->link('information/profile/hairclub',  $url . '&page={page}');
			//print_r($pagination->limit);exit();
			$data['pagination'] = $pagination->render();
			$filter_data = array(
				'start'              => ($page - 1) * $limit,
				'limit'              => $limit
			);
				$videos=$this->model_catalog_profile->getVideos($filter_data);
				//var_dump($videos);exit;
				if ($videos) {
				
						foreach ($videos as $key => $value) {
							// $videos[$key]['video']=$http_type . $_SERVER['HTTP_HOST'].'/image/video/hairclub/'. $value['video'];
							$videos[$key]['video']=HTTPS_SERVERS.'/image/video/hairclub/'. $value['video'];
							$videos[$key]['title']=$value['title'];
							$videos[$key]['image']=$this->model_tool_image->resize($value['image'],380,215);
						}
				}
			// $data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));
			// print_r($data['results']);exit();
			if ($page == 1) {
			    $this->document->addLink($this->url->link('information/profile/hairclub', '', true), 'canonical');
			} elseif ($page == 2) {
			    $this->document->addLink($this->url->link('information/profile/hairclub', '', true), 'prev');
			} else {
			    $this->document->addLink($this->url->link('information/profile/hairclub', $url . '&page='. ($page - 1), true), 'prev');
			}

			if ($limit && ceil($product_total / $limit) > $page) {
			    $this->document->addLink($this->url->link('information/profile/hairclub', $url . '&page='. ($page + 1), true), 'next');
			}

 			 $profile_video['videos']=$videos;
			   $data['profile_video']=$profile_video;

			
	
			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($data));
		}
}