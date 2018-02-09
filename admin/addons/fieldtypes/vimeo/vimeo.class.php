<?php
/**
 * A field type for Vimeo videos
 *
 * version 1.2
 * 
 * @package default
 * @author Drew McLellan
 */
class PerchFieldType_vimeo extends PerchAPI_FieldType
{
    private $api_url = 'https://vimeo.com/api/v2/video/';
    
    /**
     * Output the form fields for the edit page
     *
     * @param array $details 
     * @return void
     * @author Drew McLellan
     */
    public function render_inputs($details=array())
    {
        $id = $this->Tag->input_id();
        $val = '';
        
        if (isset($details[$id]) && $details[$id]!='') {
            $json = $details[$id];
            $val  = $json['path']; 
        }else{
            $json = array();
        }
        
        $s = $this->Form->text($this->Tag->input_id(), $val);
        
        if (isset($json['vimeoID'])) {
            $ratio = $json['height'] / $json['width'];
            $w     = 320;
            $h     = $w*$ratio;
            $s     .= '<div class="preview"><iframe src="https://player.vimeo.com/video/'.$json['vimeoID'].'?portrait=0&amp;badge=0&amp;color=ffffff" width="'.$w.'" height="'.$h.'" frameborder="0"></iframe></div>';
        }
        
        return $s;
    }
    
    
    /**
     * Read in the form input, prepare data for storage in the database.
     *
     * @param string $post 
     * @param object $Item 
     * @return void
     * @author Drew McLellan
     */
    public function get_raw($post=false, $Item=false) 
    {
        $store = array();
                
        $id = $this->Tag->id();

        if ($post===false) {
            $post = $_POST;
        }
        
        if (isset($post[$id])) {
            $this->raw_item = trim($post[$id]);
            $url = $this->raw_item;

            if ($url) {
                $store['path'] = $url;
                $store['vimeoID'] = $this->get_id($url);
            
                $details = $this->get_details($store['vimeoID']);
            
                if ($details) {
                    $store = array_merge($store, $details);
                    $store['_title'] = $store['title'];
                }else{
                    return false;
                }

                return $store;
            }
        }
        
        return false;
    }
    
    /**
     * Take the raw data input and return process values for templating
     *
     * @param string $raw 
     * @return void
     * @author Drew McLellan
     */
    public function get_processed($raw=false)
    {    
        if (is_array($raw)) {
            
            $item = $raw;
            
            
            if ($this->Tag->output() && $this->Tag->output()!='path') {
                switch($this->Tag->output()) {        
                    case 'id':
                        return isset($item['vimeoID']) ? $item['vimeoID'] : false;
                        break;

                    case 'embed':
                        $w = $item['width'];
                        $h = $item['height'];

                        if ($this->Tag->width()) {
                            $w = $this->Tag->width();
                            $h = '';

                            if ($this->Tag->height()) {
                                $h = $this->Tag->height();
                            }else{
                                $ratio = $item['height'] / $item['width'];
                                $h = $w*$ratio;
                            }
                        }

                        $this->processed_output_is_markup = true;

                        return '<iframe src="https://player.vimeo.com/video/'.$item['vimeoID'].'" width="'.$w.'" height="'.$h.'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';

                        break;

                    default:
                        if (isset($item[$this->Tag->output()])) {
                            return $item[$this->Tag->output()];
                        }
                        break;
                }

                return false;
            }
    
            return $item['path'];
        }
        return $raw;
    }
    
    /**
     * Get the value to be used for searching
     *
     * @param string $raw 
     * @return void
     * @author Drew McLellan
     */
    public function get_search_text($raw=false)
    {
        if ($raw===false) $raw = $this->get_raw();
        if (!PerchUtil::count($raw)) return false;

        if (isset($raw['title'])) return $raw['title'];

		return false;
    }
    	
	
	/**
	 * Finds the Vimeo video ID from a Vimeo URL
	 *
	 * @param string $url Vimeo video page URL
	 * @return string Vimeo ID
	 * @author Drew McLellan
	 */
    private function get_id($url)
	{
		$parts = explode('/', rtrim($url, '/'));
        $id = array_pop($parts);
        if (is_numeric($id)) return $id;
		return false;
	}
	
	
	/**
	 * Get information about the video with the given ID.
	 *
	 * @param string $videoID A Vimeo video ID
	 * @return array Assoc array of video details
	 * @author Drew McLellan
	 */
	private function get_details($videoID)
	{
		$url = $this->api_url . $videoID.'.php';
		
		$ch 	= curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$serialised_php = curl_exec($ch);
        $http_response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		
		if ($http_response=='200' && $serialised_php) {

            $data = unserialize($serialised_php);

			if (PerchUtil::count($data)) {
                $item = $data[0];

			    $out = array();
                $out['title']       = $item['title'];
                $out['description'] = $item['description'];
                $out['user_name']   = $item['user_name'];
                $out['user_url']    = $item['user_url'];
                $out['user_img']    = $item['user_portrait_huge'];
                $out['url']         = $item['url'];
                $out['thumb']       = $item['thumbnail_large'];
                $out['thumb_w']     = '640';

                $out['duration']    = $item['duration'];
                $out['width']       = $item['width'];
                $out['height']      = $item['height'];
                $out['tags']        = $item['tags'];
                $out['date']        = $item['upload_date'];
		
    			return $out;
    		}
            
		}
		
		return false;
	}

}
