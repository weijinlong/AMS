<?php

if(	!	defined('BASEPATH'))
				exit('No direct script access allowed');

/**
	* Messages
	*
	* @package    AMS
	* @subpackage Messeges
	* @author     Ali Raza, Nouman Tayyab
	*/
class	Messages	extends	MY_Controller
{

				/**
					* constructor. Load layout,Model,Library and helpers
					* 
					*/
				function	__construct()
				{
								parent::__construct();
								$this->layout	=	'main_layout.php';
				}

				/**
					* Redirect to inbox
					*  
					*/
				public	function	index()
				{
								redirect('messages/inbox',	'location');
				}

				/**
					* List Received Message 
					*  
					*/
				public	function	inbox()
				{
								$where	=	'';
								if($_POST)
								{
												if(isset($_POST['message_type']))
												{
																$where['msg_type']	=	$_POST['message_type'];
												}
												if(isset($_POST['stations']))
												{
																$where['receiver_id']	=	$_POST['stations'];
												}
								}
								$data['results']	=	$this->msgs->get_inbox_msgs($this->station_id,	$where);
								$data['station_records']	=	$this->station_model->get_all();
								if(isAjax())
								{
												$data['is_ajax']	=	true;
												echo	$this->load->view('messages/inbox',	$data,	true);
												exit;
								}
								else
								{
												$data['is_ajax']	=	false;
												$this->load->view('messages/inbox',	$data);
								}
				}

				/**
					* List Sent Message 
					*  
					*/
				public	function	sent()
				{
								if(in_array($this->role_id,	array(1,	2,	5)))
								{
												$where	=	'';
												if($_POST)
												{
																if($_POST['message_type'])
																{
																				$where['msg_type']	=	$_POST['message_type'];
																}
																if($_POST['stations'])
																{
																				$where['receiver_id']	=	$_POST['stations'];
																}
												}
												$data['station_records']	=	$this->station_model->get_all();
												$data['results']	=	$this->msgs->get_sent_msgs($this->user_id,	$where);
												if(isAjax())
												{
																$data['is_ajax']	=	true;
																echo	$this->load->view('messages/sent',	$data,	true);
																exit;
												}
												else
												{
																$data['is_ajax']	=	false;
																$this->load->view('messages/sent',	$data);
												}
								}
								else
								{
												show_404();
								}
				}

				/**
					* Get the message type and load the respective view. Receive an ajax call
					* 
					* @param $type as post parameter
					* @return html view for message type
					*  
					*/
				public	function	get_message_type()
				{
								if(isAjax())
								{
												$type	=	$this->input->post('type');
												$messagesType	=	$this->config->item('messages_type');
												$messageType	=	'_'	.	str_replace(' ',	'_',	strtolower($messagesType[$type]));
												$messageTypeFields	=	str_replace(' ',	'_',	$messagesType[$type]);
												$data['record']	=	$this->email_template->get_template_by_sys_id($messageTypeFields);
												$data['is_ajax']	=	true;
												echo	$this->load->view('messages/'	.	$messageType,	$data,	TRUE);
												exit;
								}
								show_404();
				}

				/**
					* Recieve the compose message parameteres. Store in database and send email
					* Receive an ajax call
					* 
					* @param $to receiver ids
					* @param $html for email body
					* @param $type message type
					* @param $extaras receive the remaining fields as an array
					*  
					*/
				public	function	compose()
				{
								if($this->input->post()	&&	isAjax())
								{
												$alerts_array	=	$this->config->item('messages_type');
												$html	=	$this->input->post('html');
												$type	=	$this->input->post('type');
												$same_dsd	=	($this->input->post('same_dsd'))	?	$this->input->post('same_dsd')	:	false;
												$template	=	str_replace(" ",	"_",	$alerts_array[$type]);
												$template_data	=	$this->email_template->get_template_by_sys_id($template);
												$multiple_station	=	$this->input->post('to');
												$extra	=	$this->input->post('extras');
												if(isset($template_data)	&&	!	empty($template_data))
												{
																if(isset($multiple_station)	&&	!	empty($multiple_station))
																{
																				$this->compose_station_message($multiple_station,	$template_data,	$extra,	$template,	$type);
																				echo	json_encode(array('success'	=>	TRUE));
																				exit;
																}
																else
																{
																				echo	json_encode(array('success'		=>	FALSE,	"error_id"	=>	1));
																				exit;
																}
												}
												else
												{
																echo	json_encode(array('success'		=>	FALSE,	"error_id"	=>	2));
																exit;
												}
								}
								else
								{
												show_404();
								}
				}

				/**
					*
					* @param array $multiple_station
					* @param array $template_data
					* @param array $extra
					* @param string $template
					* @param integer $type 
					*/
				function	compose_station_message($multiple_station,	$template_data,	$extra,	$template,	$type)
				{
								$message_type_check	=	0;
								foreach($multiple_station	as	$to)
								{

												$station_details	=	$this->station_model->get_station_by_id($to);
												$subject	=	$template_data->subject;

												if($template	==	'Digitization_Start_Date')
												{
																$extra['ship_date']	=	$station_details->start_date;
												}
												else	if($template	==	'Materials_Received_Digitization_Vendor')
												{

																$tracking_info	=	$this->tracking->get_last_tracking_info($to);
																if(count($tracking_info)	>	0)
																{
																				if(empty($tracking_info->media_received_date)	||	$tracking_info->media_received_date	==	null)
																				{
																								$message_type_check	=	1;
																				}
																				else
																				{
																								$message_type_check	=	0;
																								$extra['date_received']	=	$tracking_info->media_received_date;
																				}
																}
												}
												else if($template	==	'Shipment_Return')
												{

																$tracking_info	=	$this->tracking->get_last_tracking_info($to);
																if(count($tracking_info)	>	0)
																{
																				if(empty($tracking_info->ship_date)	||	$tracking_info->ship_date	==	NULL)
																				{
																								$message_type_check	=	1;
																				}
																				else
																				{
																								$message_type_check	=	0;
																								$extra['ship_date']	=	$tracking_info->ship_date;
																				}
																}
												}
												if($message_type_check	==	0)
												{
																foreach($extra	as	$key	=>	$value)
																{
																				$replacebale[$key]	=	(isset($value)	&&	!	empty($value))	?	$value	:	'';
																}

																$replacebale['station_name']	=	isset($station_details->station_name)	?	$station_details->station_name	:	'';
																if($this->config->item('demo')	==	TRUE)
																{
																				$to_email	=	$this->config->item('to_email');
																				$from_email	=	$this->config->item('from_email');
																				$replacebale['user_name']	=	'AMS';
																				$this->emailtemplates->sent_now	=	TRUE;
																}
																else
																{
																				$to_email	=	$station_details->contact_email;
																				$from_email	=	$this->user_detail->email;
																				$replacebale['user_name']	=	$this->user_detail->first_name	.	' '	.	$this->user_detail->last_name;
																}
																$replacebale['inform_to']	=	'ssapienza@cpb.org';
																$email_queue_id	=	$this->emailtemplates->queue_email($template,	$to_email,	$replacebale);

																$data	=	array('sender_id'			=>	$this->user_id,	'receiver_id'	=>	$to,	'msg_type'				=>	$type,	'subject'					=>	$subject,	'msg_extras'		=>	json_encode($extra),	'created_at'		=>	date('Y-m-d h:m:i'));
																if(isset($email_queue_id)	&&	$email_queue_id)
																{
																				$data['email_queue_id']	=	$email_queue_id;
																}
																$this->msgs->add_msg($data);
																$this->session->set_userdata('sent',	'Message Sent');
												}
								}
				}

				/**
					* Recieve the message id
					* 
					* @param $message_id msg id
					*  Display Message details
					*/
				public	function	readmessage($message_id	=	'')
				{
								if(isAjax())
								{
												$rslt["total_unread_text"]	=	'<a href="'	.	site_url('messages/inbox')	.	'">Messages</a>';
												$rslt["error"]	=	true;
												$rslt["reset_row"]	=	false;
												if($message_id	!=	'')
												{
																$data['result']	=	$this->msgs->get_inbox_msgs($this->station_id,	array("id"	=>	$message_id));
																if(isset($data['result'])	&&	!	empty($data['result'])	&&	$data['result'][0]->msg_status	==	'unread'	&&	!	$this->can_compose_alert)
																{
																				$this->msgs->update_msg_by_id($message_id,	array("msg_status"	=>	'read',	"read_at"				=>	date('Y-m-d H:i:s')));
																				$this->total_unread	=	$this->msgs->get_unread_msgs_count($this->user_id);
																				if(isset($this->total_unread)	&&	$this->total_unread	>	0	&&	$this->is_station_user)
																				{
																								$rslt["total_unread_text"]	=	'<a class="btn large message" href="'	.	site_url('messages/inbox')	.	'">Messages<span class="badge label-important message-alert">'	.	$this->total_unread	.	'</span></a>';
																								$rslt["reset_row"]	=	true;
																				}
																}
																$rslt["error"]	=	false;
																$rslt["msg_data"]	=	$this->load->view('messages/read_msg',	$data,	true);
																echo	json_encode($rslt);
																exit;
												}
												else
												{
																echo	json_encode($rslt);
																exit;
												}
								}
								else
								{
												show_404();
								}
				}

				public	function	readsentmessage($message_id	=	'')
				{
								if(isAjax())
								{
												$rslt["error"]	=	true;
												if($this->can_compose_alert)
												{
																if($message_id	!=	'')
																{
																				$data['result']	=	$this->msgs->get_sent_msgs($this->user_id,	array("id"														=>	$message_id));
																				$rslt["error"]	=	false;
																				$rslt["msg_data"]	=	$this->load->view('messages/read_msg',	$data,	true);
																				echo	json_encode($rslt);
																				exit;
																}
																else
																{
																				echo	json_encode($rslt);
																				exit;
																}
												}
												else
												{
																echo	json_encode($rslt);
																exit;
												}
								}
								else
								{
												show_404();
								}
				}

}

?>