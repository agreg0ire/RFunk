<?php

/**
 * @link            https://github.com/eclectric-music/RFunk
 * @filesource      of RFunk class
 * @author          eclectricmusic      
 */
	
class RFunk
{
		
        
        /**
         * @var     const DS
         * @var     $i_diviseur_mo which is private
         */
         
		const DS=DIRECTORY_SEPARATOR;
		
		private $i_diviseur_mo=1;
        
        /**
         * @name    constructor
         * @param   p1 int in order to set a script execution time limit
         * @return  void
         */
	
		public function __construct($p1_i_max_time=0) 
		{
		  for($i=0; $i<20; $i++):  $this->i_diviseur_mo *=2; endfor;
          
		  if(is_int($p1_i_max_time))  @set_time_limit($p1_i_max_time);
			
			
		}
		/**
         * @name    indent
         * @param   p1 string source
         * @param   p2 string single car to repeat
         * @param   p3 int repeater
         * @return  string
         */
		private function indent($p1_s_dir_orig, $p2_s_single_car, $p3_i_incr)
		{
			
			$s_to_add=str_repeat($p2_s_single_car, $p3_i_incr);
				
			$s_formated=$s_to_add.$p1_s_dir_orig;
				
			return $s_formated;
				
		}
		
        /**
         * @name    strrchr2
         * @param   p1 string source to be splited
         * @param   p2 string spliter
         * @return  string
         */
		private function strrchr2($p1_s_src, $p2_s_spliter)
		{
			
			$a_splited=explode($p2_s_spliter, $p1_s_src);
			
			$i_num_keys=count($a_splited);
			
			return strtolower($a_splited[$i_num_keys - 1]);
		}
		/**
         * @name    removeUTF8BOMHeader
         * @param   p1 string to ASCII file source
         * @return  string
         */
        
		private function removeUTF8BOMHeader($p1_s_path_to_file)
		{
			 $h_file = fopen($p1_s_path_to_file, "r");
			 $s_all_file = fread($h_file, filesize($p1_s_path_to_file));
			 fclose($h_file);
			 $s_header = substr($s_all_file,0,3);
			 
			if ($s_header == "\xEF\xBB\xBF")
		  	{
		  		return substr($s_all_file, 3);
		              
		    }else return $s_all_file; 
		}
		
		/**
         * @name    calculSize
         * @param   p1 string to source dir
         * @param   p2 boolean whether if want to round result
         * @param   p3 string to choose a specific file ext
         * @return  int
         */
		public function calculSize($p1_s_dir_src='.', $p2_b_for_round=true, $p3_s_by_type='')
		{
	
			static $ic_octet_from_files;  
			
			$h_dir=opendir($p1_s_dir_src);
	  
			while($s_mixed_output=readdir($h_dir))
			{
				
				if(is_file($p1_s_dir_src.self::DS.$s_mixed_output))
				{
					
					
					if(!empty($p3_s_by_type))
					{
						$s_ext_file=$this->strrchr2($s_mixed_output, '.');
						
						if($s_ext_file == $p3_s_by_type)
						{
							$ic_octet_from_files +=filesize($p1_s_dir_src.self::DS.$s_mixed_output); 
						}
						
					}else $ic_octet_from_files +=filesize($p1_s_dir_src.self::DS.$s_mixed_output);
					
					
				}elseif(is_dir($p1_s_dir_src.self::DS.$s_mixed_output) && $s_mixed_output!='.' && $s_mixed_output!='..')
				{
					
					$this->calculSize($p1_s_dir_src.self::DS.$s_mixed_output, $p2_b_for_round, $p3_s_by_type);
				}
				
			}
			closedir($h_dir);
			
			if($p2_b_for_round)
			{
			
				return round($ic_octet_from_files / $this->i_diviseur_mo);
				
			}else return $ic_octet_from_files / $this->i_diviseur_mo;
			
		}	
		/**
         * @name    getFilesPaths
         * @param   p1 string to source dir
         * @return  mixed array of dir path on succes or bool false on failure
         */
        
		public  function getFilesPaths($p1_s_dir_src = '.') 
		{
            static $a_all_paths = array();
			
			$h_dir=opendir($p1_s_dir_src);
		  
				while($s_mixed_output=readdir($h_dir))
				{
					
					if(is_file($p1_s_dir_src.self::DS.$s_mixed_output))
					{
						$a_all_paths []=$p1_s_dir_src.self::DS.$s_mixed_output;
						
					}elseif(is_dir($p1_s_dir_src.self::DS.$s_mixed_output) && $s_mixed_output!='.' && $s_mixed_output!='..')
					{
						
						$this->getFilesPaths($p1_s_dir_src.self::DS.$s_mixed_output);
						
					}
					
				}
				closedir($h_dir);
			
				if(count($a_all_paths) > 0)
                {  
                    return $a_all_paths;
                    
                }else return false; 
		}
        
        /**
         * @name        getAllFilesAndDirsPaths
         * @param       p1 string of source dir
         * @return      mixed a multidim with file path from one side and dir path in one other or bool false on failure
         */
        
        public function getAllFilesAndDirsPaths($p1_s_dir_src = '.')
        {
            static $mda_files_and_dirs_paths;
            
            $h_dir = opendir($p1_s_dir_src);
            
            while($s_looped_elements = readdir($h_dir)):
            
                if(is_file($p1_s_dir_src.self::DS.$s_looped_elements))
                {
                    $mda_files_and_dirs_paths ['files_paths'] [] = $p1_s_dir_src.self::DS.$s_looped_elements;
                    
                }elseif(is_dir($p1_s_dir_src.self::DS.$s_looped_elements) && $s_looped_elements != '.' && $s_looped_elements != '..')
                {
                    $mda_files_and_dirs_paths ['dirs_paths'] [] = $p1_s_dir_src.self::DS.$s_looped_elements;
                    
                    $this->getAllFilesAndDirsPaths($p1_s_dir_src.self::DS.$s_looped_elements);
                }
            
            endwhile;
            
            closedir($h_dir);
            
            
            if(is_array($mda_files_and_dirs_paths) && count($mda_files_and_dirs_paths) > 0)
            {
                return $mda_files_and_dirs_paths;
                
            }else return FALSE;
        }
        
        /**
         * @name    getFilesAndDirsPathsWithOptions
         * @param   p1 string of source dir
         * @param   p2 string of keyword that match with file or dirname
         * @return  mixed a multidim with file path from one side and dir path in one other or bool false on failure
         */
        
        public function getFilesAndDirsPathsWithOptions($p1_s_dir_src = '.', $p2_s_searched_keyword = NULL)
         {
            if($p2_s_searched_keyword == NULL) return FALSE;
            
            static $mda_files_and_dirs_paths;
            
            $h_dir = opendir($p1_s_dir_src);
            
            while($s_looped_elements = readdir($h_dir)):
            
                if(is_file($p1_s_dir_src.self::DS.$s_looped_elements))
                {
                    if(stripos($p1_s_dir_src.self::DS.$s_looped_elements, $p2_s_searched_keyword) !== FALSE)
                    {
                        $mda_files_and_dirs_paths ['files_paths'] [] = $p1_s_dir_src.self::DS.$s_looped_elements;   
                    }
                    
                }elseif(is_dir($p1_s_dir_src.self::DS.$s_looped_elements) && $s_looped_elements != '.' && $s_looped_elements != '..')
                {
                    if(stripos($p1_s_dir_src.self::DS.$s_looped_elements, $p2_s_searched_keyword) !== FALSE)
                    {
                        $mda_files_and_dirs_paths ['dirs_paths'] [] = $p1_s_dir_src.self::DS.$s_looped_elements;
                    }
                    
                    $this->getFilesAndDirsPathsWithOptions($p1_s_dir_src.self::DS.$s_looped_elements, $p2_s_searched_keyword);
                }
            
            endwhile;
            
            closedir($h_dir);
            
            
            if(is_array($mda_files_and_dirs_paths) && count($mda_files_and_dirs_paths) > 0)
            {
                return $mda_files_and_dirs_paths;
                
            }else return FALSE;
        }
        
		
        /**
         * @name    getFilesPathsSvnVersion
         * @param   p1 string of source dir
         * @param   p2 array specific ext file
         * @param   p3 string   source dir retain same value in recursion
         * @return  mixed a multidim with file path or bool false on failure
         */
		public  function getFilesPathsSvnVersion($p1_s_dir_src='.', array $p2_a_specified_extensions, $p3_s_dir_src_not_changing) 
		{
			
			static $i_count_r, $a_files_paths_and_contents;
		
			$i_count_r++;
			
			if($i_count_r == 1)
			{
				$p1_s_dir_src = str_replace('\\', '/', $p1_s_dir_src); //in case of
				$p3_s_dir_src_not_changing = $p1_s_dir_src;
				
			} 
		
		
			$h_dir=opendir($p1_s_dir_src);
		  
				while($s_mixed_output=readdir($h_dir))
				{
					
					if(is_file($p1_s_dir_src.self::DS.$s_mixed_output))
					{
						
					 	if(in_array(strrchr($p1_s_dir_src.self::DS.$s_mixed_output, '.'), $p2_a_specified_extensions))
					 	{
					 		
					 		$s_cleaned_content_from_client = $this->removeUTF8BOMHeader($p1_s_dir_src.self::DS.$s_mixed_output);
					 		
					 		$a_files_paths_and_contents['file_ok'][substr($p1_s_dir_src.self::DS.$s_mixed_output, strlen($p3_s_dir_src_not_changing))]= $s_cleaned_content_from_client;
					 		
					 	}
					
					}elseif(is_dir($p1_s_dir_src.self::DS.$s_mixed_output) && $s_mixed_output!='.' && $s_mixed_output!='..')
					{
						
						$this->getFilesPathsSvnVersion($p1_s_dir_src.self::DS.$s_mixed_output, $p2_a_specified_extensions, $p3_s_dir_src_not_changing);
						
					}
					
				}
				closedir($h_dir);
			
			
				if(is_array($a_files_paths_and_contents) && count($a_files_paths_and_contents) > 0)
				{
					return $a_files_paths_and_contents;
					
				}else return false; 
				
				
		}
        
        /**
         * @name    getDirsPaths
         * @param   p1 string of source dir
         * @return  mixed array of dirpath on success or bool false on failure
         */
		
		public function getDirsPaths($p1_s_dir_src='.')
		{
	
	       
			    static $a_all_paths; 
			       
				$h_dir=opendir($p1_s_dir_src);
			 
			        while($s_mixed_output=readdir($h_dir))
			        {
			       
			            if(is_dir($p1_s_dir_src.self::DS.$s_mixed_output) && $s_mixed_output!='.' && $s_mixed_output!='..')
			            {
			               
			                $a_all_paths []=$p1_s_dir_src.self::DS.$s_mixed_output;
			               
			                $this->getDirsPaths($p1_s_dir_src.self::DS.$s_mixed_output);
			               
			            }
			           
			        }
			    closedir($h_dir);
			    
			    if(count($a_all_paths) > 0)
                {  
                    return $a_all_paths;
                
                }else return false; 
	   
		} 
        /**
         * @name    getAllExts
         * @param   p1  string of source dir
         * @return  mixed array of all found ext file or bool false on failure
         */
		
			public function getAllExts($p1_s_dir_src='.')
			{
			
			static $a_all_exts;
			
			$h_dir=opendir($p1_s_dir_src);
			
				while($s_looped_elements=readdir($h_dir))
				{
					if(is_file($p1_s_dir_src.self::DS.$s_looped_elements))
					{
						
							$s_looped_exts=$this->strrchr2($s_looped_elements, '.');
							
							if(@!in_array($s_looped_exts, $a_all_exts))  $a_all_exts []=$s_looped_exts;
							
							
					}elseif(is_dir($p1_s_dir_src.self::DS.$s_looped_elements) && $s_looped_elements!='.' && $s_looped_elements!='..' )
					{
						$this->getAllExts($p1_s_dir_src.self::DS.$s_looped_elements);
					}
					
				}
			closedir($h_dir);
			
			if(count($a_all_exts) > 0)
            { 
                return $a_all_exts;
            
            }else return false; 	
		}
		
		/**
         * @name    rmFiles
         * @param   p1 string of source dir
         * @param   p2 array of files not to be removed
         * @return  mixed array with files locked or bool false if no files were found
         */
	
		public  function rmFiles($p1_s_dir_src='.', array $p2_a_files_to_avoid)
		{
		
				static $a_files_in_error;
				
				$h_dir=opendir($p1_s_dir_src);
		  
				while($s_mixed_output=readdir($h_dir))
				{
					
					if(is_file($p1_s_dir_src.self::DS.$s_mixed_output))
					{
					   if(!in_array($s_mixed_output, $p2_a_files_to_avoid))
                       {
                            if(!@unlink($p1_s_dir_src.self::DS.$s_mixed_output)) $a_files_in_error [] = $p1_s_dir_src.self::DS.$s_mixed_output;
                       }
						
				
					}elseif(is_dir($p1_s_dir_src.self::DS.$s_mixed_output) && $s_mixed_output!='.' && $s_mixed_output!='..')
					{
						
						$this->rmFiles($p1_s_dir_src.self::DS.$s_mixed_output, $p2_a_files_to_avoid);
						
					}
					
				}
			closedir($h_dir);
			
			if(count($a_files_in_error) > 0)
            {  
                return $a_files_in_error;
                
            }else return true;
			
		}

        /**
         * @name    rmParentDir
         * @param   p1 string of source dir
         * @return  void
         */
	
	public function rmParentDir($p1_s_dir_src)
	{
	       if(count(scandir($p1_s_dir_src))<=2)
	        {
	               
	            if(@rmdir($p1_s_dir_src))
	            {
	                   
	                    $s_format=strrchr($p1_s_dir_src,self::DS);
	                    $i_length_retour_prev=strlen($s_format);
	                    $s_parent_path_for_new_scan=substr($p1_s_dir_src,0,-$i_length_retour_prev);
	               
	                    $this->rmParentDir($s_parent_path_for_new_scan);
	            }
	           
	        }
	}

    /**
     * @name    separateFilesByMaxSize
     * @param   p1 string of source dir
     * @param   p2 srtring of destination dir
     * @param   p3 string of a prefix dest dir
     * @param   p4 int maxfilesize foreach dest dir by ext in mo
     * @return  mixed array of files that could not be renamed or bool true on success
     * @since   does not use a recursion by folder but according to the filesize
     * @todo    is not to specify a root dir with sub dir
     */
	public function separateFilesByMaxSize($p1_dir_src, $p2_s_dir_dest='.', $p3_s_dir_root='root_', $p4_i_size_limit_rep_mo=2) 
	{
		
		
		static $a_files_in_error, $i_compteur_recursivite;
		$i_compteur_recursivite++;
				
		if(@mkdir($p2_s_dir_dest.self::DS.$p3_s_dir_root.self::DS.$i_compteur_recursivite,0777,TRUE))
		{
								
			$h_dir=opendir($p1_dir_src);
						
				while($s_output_looped=readdir($h_dir)):
				
					if(is_file($p1_dir_src.self::DS.$s_output_looped))
					{
											
						$ic_octet_img +=filesize($p1_dir_src.self::DS.$s_output_looped);
											
						if($ic_octet_img / $this->i_diviseur_mo < $p4_i_size_limit_rep_mo)
						{
												
							if(@rename($p1_dir_src.self::DS.$s_output_looped, $p2_s_dir_dest.self::DS.$p3_s_dir_root.self::DS.$i_compteur_recursivite.self::DS.$s_output_looped))
							{
							}else $a_files_in_error []=$p1_dir_src.self::DS.$s_output_looped;
											
						}else 	$this->separateFilesByMaxSize($p1_dir_src, $p2_s_dir_dest, $p3_s_dir_root, $p4_i_size_limit_rep_mo);
					}
					
				endwhile;
						
			closedir($h_dir);
						
			if(count($a_files_in_error) > 0)
            { 
                return $a_files_in_error;
            
            }else return true;  
		}
					
	}

    /**
     * @name    separateFilesByExts
     * @param   p1 string of source dir
     * @param   p2 string of destination dir
     * @param   p3 array of specified exts
    * @return  mixed array of files that could not be renamed or bool true on success
    */

	public function separateFilesByExts($p1_s_dir_src, $p2_s_dir_path_dest, array $p4_a_exts)
	{
		
			static $a_files_in_error, $i_count_recur;
			
			$i_count_recur++;
			
			if($i_count_recur <= 1)
			{
				foreach($p4_a_exts as $i_key => $s_value):
				
					if(@mkdir($p2_s_dir_path_dest.self::DS.$s_value,0777, true)){ }
					
				endforeach;
			}
		
			$h_dir=opendir($p1_s_dir_src);
			
				while($s_looped_elements=readdir($h_dir)):
				
					if(is_file($p1_s_dir_src.self::DS.$s_looped_elements))
					{
							$s_looped_exts=$this->strrchr2($s_looped_elements, '.');
							
						foreach($p4_a_exts as $i_key => $s_value)
						{
							if($s_looped_exts == strtolower($s_value))
							{
								if(@rename($p1_s_dir_src.self::DS.$s_looped_elements, $p2_s_dir_path_dest.self::DS.$s_value.self::DS.$s_looped_elements))
								{
								
								}else $a_files_in_error []=$p1_s_dir_src.self::DS.$s_looped_elements; 
							}
						}
							
					}elseif(is_dir($p1_s_dir_src.self::DS.$s_looped_elements) && $s_looped_elements!='.' && $s_looped_elements!='..' )
					{
						
						$this->separateFilesByExts($p1_s_dir_src.self::DS.$s_looped_elements, $p2_s_dir_path_dest, $p4_a_exts);
					}
					
				endwhile;
                
			closedir($h_dir);
			
			if(count($a_files_in_error) >0)
            {  
                return $a_files_in_error;
                
            }else return true;
	}
    
    /**
     * @name    joinFilesInOneFolder
     * @param   p1 string of source dir
     * @param   p2 string of destination dir
     * @param   p3 bool to determine whether you want to rename file or copy them
     * @return  mixed array of files that could not be renamed or copied or bool true on success
     */


		public function joinFilesInOneFolder($p1_s_dir_src, $p2_s_dir_dest, $p3_b_for_cut=true)
		{
				
				static $a_files_in_error;
				
				if(!is_dir($p2_s_dir_dest)) mkdir($p2_s_dir_dest, 0777, true);
		
				$h_dir=opendir($p1_s_dir_src);
				
					while($s_looped_elements=readdir($h_dir)):
					
						if(is_file($p1_s_dir_src.self::DS.$s_looped_elements))
						{
							
							if($p3_b_for_cut)
							{
								
								if(@rename($p1_s_dir_src.self::DS.$s_looped_elements, $p2_s_dir_dest.self::DS.$s_looped_elements))
								{
								
								}else $a_files_in_error []=$p1_s_dir_src.self::DS.$s_looped_elements; 
									
							}else{
							
									if(@copy($p1_s_dir_src.self::DS.$s_looped_elements, $p2_s_dir_dest.self::DS.$s_looped_elements))
									{
								
									}else $a_files_in_error []=$p1_s_dir_src.self::DS.$s_looped_elements; 
									
								}
								
						}elseif(is_dir($p1_s_dir_src.self::DS.$s_looped_elements) && $s_looped_elements!='.' && $s_looped_elements!='..' )
						{
							
								$this->joinFilesInOneFolder($p1_s_dir_src.self::DS.$s_looped_elements, $p2_s_dir_dest, $p3_b_for_cut);
						}
					endwhile;
				
				closedir($h_dir);
				
				if(count($a_files_in_error) > 0)
                {	
                    return $a_files_in_error; 
                
                }else return true; 
			}
	
    /**
     * @name    findStr
     * @param   p1 string for source dir
     * @param   p2  string searched pattern
     * @param   p3 array of ascii ext files
     * @param   p4 bool for case sensitive
     * @param   P5 bool for display line number in file
    * @return  mixed multidim array with string key of filepath and name containing sublevel array with int key of line file where keyword is found. Or bool false if nothing was found.
    */
		
	public function findStr($p1_s_root_dir='.', $p2_s_searched_pattern, array $p3_a_ext_ascii, $p4_b_for_casse_sensitive=false, $p5_b_for_view_line=true, $p6_b_for_regexp=false)
	{
			
		static $a_retour_result;
		
			$h_dir=opendir($p1_s_root_dir);
		
			while($s_looped_elements=readdir($h_dir)):	
	
				if(is_file($p1_s_root_dir.self::DS.$s_looped_elements))
				{
					
					$s_ext=$this->strrchr2($s_looped_elements, '.');
					
					if(in_array($s_ext, $p3_a_ext_ascii))
					{
						
						
						if($a_rows_file=@file($p1_s_root_dir.self::DS.$s_looped_elements))
						{
					
							foreach($a_rows_file as $i_k_rows_file => $s_v_rows_file):
							
							
								if(!$p4_b_for_casse_sensitive)
								{
								
									if(!$p6_b_for_regexp)
									{
										
										if(preg_match('#'.$p2_s_searched_pattern.'#i', $s_v_rows_file)) 
										{	
										
											$s_v_rows_fil_clean_chevrons=strtr($s_v_rows_file,'<>', '__');
											
										
											
											if($s_output=@preg_replace('#'.$p2_s_searched_pattern.'#i', '<b>'.$p2_s_searched_pattern.'</b>', $s_v_rows_fil_clean_chevrons))
											{
												if($p5_b_for_view_line)
												{
													
													$a_retour_result[$p1_s_root_dir.self::DS.$s_looped_elements] [($i_k_rows_file + 1)]= $s_output;
													 
												}else  $a_retour_result[$p1_s_root_dir.self::DS.$s_looped_elements] []= $s_output;
												
											}
											
										}
										
									}else{
										
												if(preg_match_all('#'.$p2_s_searched_pattern.'#i', $s_v_rows_file, $mda_matches)) 
												{	
												
													$s_v_rows_fil_clean_chevrons=strtr($s_v_rows_file,'<>', '__');
													
														foreach($mda_matches[0] as $i_k_matches => $s_v_matches):  
													
															$s_double_anti_slash=str_replace('\\', str_repeat('\\', 2), $s_v_matches);
															
															$a_jokers_chars=array('*','(',')','[',']','+','|','^','?','$','-','.', '{','}','#');
									
															$a_escape_jokers=array('\*','\(','\)','\[','\]','\+','\|','\^','\?','\$','\-','\.','\{','\}','\#');
													
															$s_clean_metacar=str_replace($a_jokers_chars,$a_escape_jokers, $s_double_anti_slash);
															
															$s_output=preg_replace('#'.$s_clean_metacar.'#i', '<b>'.$s_v_matches.'</b>', $s_v_rows_fil_clean_chevrons);
														
															if($p5_b_for_view_line)
															{
																		
																$a_retour_result[$p1_s_root_dir.self::DS.$s_looped_elements] [($i_k_rows_file + 1)]= $s_output;
																		 
															}else  $a_retour_result[$p1_s_root_dir.self::DS.$s_looped_elements] []= $s_output;
																
														endforeach;
												}
										}
									
								}else{
								
										
										if(!$p6_b_for_regexp)
										{
											
											if(preg_match('#'.$p2_s_searched_pattern.'#', $s_v_rows_file)) 
											{	
											
												$s_v_rows_fil_clean_chevrons=strtr($s_v_rows_file,'<>', '__');
												
												if($s_output=@preg_replace('#'.$p2_s_searched_pattern.'#', '<b>'.$p2_s_searched_pattern.'</b>', $s_v_rows_fil_clean_chevrons))
												{
													if($p5_b_for_view_line)
													{
														
														$a_retour_result[$p1_s_root_dir.self::DS.$s_looped_elements] [($i_k_rows_file + 1)]= $s_output;
														 
													}else $a_retour_result[$p1_s_root_dir.self::DS.$s_looped_elements] []= $s_output;
													
												}
												
											}
											
										}else{
											
													if(preg_match_all('#'.$p2_s_searched_pattern.'#', $s_v_rows_file, $mda_matches)) 
													{	
													
														$s_v_rows_fil_clean_chevrons=strtr($s_v_rows_file,'<>', '__');
													
														foreach($mda_matches[0] as $i_k_matches => $s_v_matches):  
													
															$s_double_anti_slash=str_replace('\\', str_repeat('\\', 2), $s_v_matches);
															
															$a_jokers_chars=array('*','(',')','[',']','+','|','^','?','$','-','.', '{','}','#');
									
															$a_escape_jokers=array('\*','\(','\)','\[','\]','\+','\|','\^','\?','\$','\-','\.','\{','\}','\#');
													
															$s_clean_metacar=str_replace($a_jokers_chars,$a_escape_jokers, $s_double_anti_slash);
															
															$s_output=preg_replace('#'.$s_clean_metacar.'#i', '<b>'.$s_v_matches.'</b>', $s_v_rows_fil_clean_chevrons);
														
															if($p5_b_for_view_line)
															{
																		
																$a_retour_result[$p1_s_root_dir.self::DS.$s_looped_elements] [($i_k_rows_file + 1)]= $s_output;
																		 
															}else{  $a_retour_result[$p1_s_root_dir.self::DS.$s_looped_elements] []= $s_output; }
																
														endforeach;
													}
											}
										
									}
							endforeach;
							
						}
					}
					
					
				}elseif(is_dir($p1_s_root_dir.self::DS.$s_looped_elements) && $s_looped_elements !='.' && $s_looped_elements !='..')
				{
					
					$this->findStr($p1_s_root_dir.self::DS.$s_looped_elements, $p2_s_searched_pattern, $p3_a_ext_ascii, $p4_b_for_casse_sensitive, $p5_b_for_view_line, $p6_b_for_regexp);
				}
			endwhile;
		
	closedir($h_dir);
		
		if(count($a_retour_result) > 0)
        { 
            return $a_retour_result;
        
        }else return false; 
	}   
	   
    /**
     * @name    dump
     * @param p1 mixed var
    * @return  string of results on a type and value of a variable
    * @example  does not work like var_dump(); you need to echo the results : echo $o->dump(array('test', true, 0.2));
    */
	  
	public function dump($p1_m_var = null)
 	{
		static $i_num_imbricated_array;
	 	static $i_num_obj;
	 	
        
	 	if(func_num_args() > 1) die('<b>WARNING :: You try to pass more than one var ! </b><br /> ');
	 	
	 	if(is_null($p1_m_var))
	 	{
	 		$sc_display_dump .= '<b>NULL</b>';
	 		
	 	}elseif(is_string($p1_m_var))
	 	{
	 		
	 		$sc_display_dump .= '<font color="blue">STRING</font> ('.strlen($p1_m_var).') "'.$p1_m_var.'"';
	 		
	 	}elseif(is_bool($p1_m_var))
	 	{
	 		
	 		if($p1_m_var)
	 		{
	 			$sc_display_dump .= '<font color="green">BOOL</font> (true)';
	 			
	 		}else{ $sc_display_dump .= '<font color="green">BOOL</font> (false)'; }
	 		
		}elseif(is_int($p1_m_var))
	 	{
	 		$sc_display_dump .= '<font color="teal" >INT</font> ('.$p1_m_var.')';
	 		
	 	}elseif(is_float($p1_m_var))
	 	{
	 		$sc_display_dump .= '<font color="orange">FLOAT</font> ('.$p1_m_var.')';
	 		
	 	}elseif(is_resource($p1_m_var))
	 	{
	 		
	 		$sc_display_dump .= '<font color="purple">RESOURCE</font> of type ('.get_resource_type($p1_m_var).')';
	 		
	 	}elseif(is_object($p1_m_var))
	 	{
	 		$i_num_obj++;
	 		
	 		$sc_display_dump .= '<a  style="color: #800000; cursor: pointer;" 
			 		onclick="(document.getElementById(\'obj_'.$i_num_obj.'\').style.display == \'block\') ? document.getElementById(\'obj_'.$i_num_obj.'\').style.display = \'none\' : document.getElementById(\'obj_'.$i_num_obj.'\').style.display = \'block\';" >
					 OBJECT :: '.get_class($p1_m_var).'</a>';
					 
			$m_public_props = get_class_vars(get_class($p1_m_var));		 
	 		
	 		$sc_display_dump .= '<ul id="obj_'.$i_num_obj.'" style="display: none; list-style-type: none;"><br /> 
			 					<li> PUBLIC PROP ('.count($m_public_props).'):: </li>';
	 		
	 		if(is_array($m_public_props) && count($m_public_props) > 0)
	 		{
	 			foreach($m_public_props as $m_key => $m_value):
	 			
	 				$sc_display_dump .= '<li>&nbsp;'.$m_key.' => '.$this->dump($m_value).'</li>';
	 			
	 			endforeach;
	 		}
	 		
			$m_public_methods = get_class_methods($p1_m_var);
	 		
	 		$sc_display_dump .= '<li>PUBLIC METHODS ('.count($m_public_methods).') :: </li>';
			 
			 if(is_array($m_public_methods) && count($m_public_methods) > 0)
			 {
			 	foreach($m_public_methods as $m_key => $m_value):
			 	
			 		$sc_display_dump .= '<li>&nbsp;'.$m_value.'</li>';
			 		
			 	endforeach;
			 } 
			 
			 $sc_display_dump .= '</ul>';
		 	
	 	}elseif(is_array($p1_m_var))
	 	{
	 		$i_num_imbricated_array++;
	 		
	 		$sc_display_dump .= '<a  style="color: #FF0000; cursor: pointer;"
			 					onclick="(document.getElementById(\'level_'.$i_num_imbricated_array.'\').style.display == \'block\') ? document.getElementById(\'level_'.$i_num_imbricated_array.'\').style.display = \'none\' : document.getElementById(\'level_'.$i_num_imbricated_array.'\').style.display = \'block\';">
								 ARRAY</a> ('.count($p1_m_var).')
								<ul style="list-style-type: none; display: none;" id="level_'.$i_num_imbricated_array.'"> { ';
	 		
	 		foreach($p1_m_var as $m_key => $m_value):
	 		
	 			if(is_int($m_key))
	 			{
	 				$sc_display_dump .=  '<li>&nbsp;&nbsp;['.$m_key.'] => '.$this->dump($m_value).'</li>';
	 				
	 			}elseif(is_string($m_key))
			 	{ 
			 		$sc_display_dump .=  '<li>&nbsp;&nbsp;["'.$m_key.'"] => '.$this->dump($m_value).'</li>'; 
					 
					 
			 	}else	$this->dump($m_key); 
	 		
	 		endforeach;
	 		
	 		$sc_display_dump .=  ' } </ul>';
	 	}
	 	
	 	return $sc_display_dump;
 	}
	
	/**
     * @name    zipFiles
     * @param   p1 string for source dir
     * @param   p2 srting for extraction dest dir
     * @param   p3 string for prefixing zip dest archives
     * @param   p4 integer for filesize limit to archive
    * @return  mixed array with file superior to maxfilesize or bool true on success
    */
		public function zipFiles($p1_s_dir_src, $p2_s_dir_dest='.', $p3_s_zips_name='output_', $p4_i_max_file_size=4)
		{
		 	
		 	$o_z=new ZipArchive;
		 	
		 	static $a_files_up_to_max_filesize, $i_count_recur;
		 	
		 	$i_count_recur++;
		 	
		 	$o_z->open($p2_s_dir_dest.self::DS.$p3_s_zips_name.$i_count_recur.'.zip',ZIPARCHIVE::CREATE);
		 	
				$h_dir=opendir($p1_s_dir_src);
					
					while($s_output_looped=readdir($h_dir)):
					
						if(is_file($p1_s_dir_src.self::DS.$s_output_looped))
						{
							if(filesize($p1_s_dir_src.self::DS.$s_output_looped) / $this->i_diviseur_mo <= $p4_i_max_file_size)
							{
									
								$o_z->addFile($p1_s_dir_src.self::DS.$s_output_looped,$s_output_looped);
										
							}else $a_files_up_to_max_filesize []= $p1_s_dir_src.self::DS.$s_output_looped;
									
						}elseif(is_dir($p1_s_dir_src.self::DS.$s_output_looped) && $s_output_looped!='.' && $s_output_looped!='..')
						{
									
							$this->zipFiles($p1_s_dir_src.self::DS.$s_output_looped, $p2_s_dir_dest, $p3_s_zips_name, $p4_i_max_file_size);
									
						}
								
					endwhile;
                    
				closedir($h_dir);
                
			$o_z->close();
			
			if(count($a_files_up_to_max_filesize)> 0)
            { 
                return $a_files_up_to_max_filesize;
            
            }else return true; 
		 	
		}
		
		/**
         * @name    unZipFolders
         * @param   p1 string for source dir
         * @param   p2 string for extraction zip dir dest
         * @param   p3 integer for max filesize zip
         * @param   p4 boolean for keep tree zip structure
        * @return  mixed multidim array on success or bool false on failure
        * @global  var $o_z must be closed outside the function
        */
		
		
		public function unZipFolders($p1_s_dir_src, $p2_s_dir_dest='.', $p3_i_max_size_zip=5, $p4_b_for_keep_arbo=true)
		{
			
			global $o_z;
			
			static $mda_exceptions, $i_count_recur;
			$i_count_recur++;
			
			if($i_count_recur <= 1)
			{
				$o_z=new ZipArchive;
			}
			
				$h_dir=opendir($p1_s_dir_src);
						
						while($s_looped_elements=readdir($h_dir)):
						
							if(is_file($p1_s_dir_src.self::DS.$s_looped_elements))
							{
								
								$s_ext=$this->strrchr2($s_looped_elements, '.');
								
								if($s_ext=='zip')
								{
									
									if((filesize($p1_s_dir_src.self::DS.$s_looped_elements) / $this->i_diviseur_mo) < $p3_i_max_size_zip)
									{
										
										$mda_exceptions['ZIPS < '.$p3_i_max_size_zip.' MO'] []= $p1_s_dir_src.self::DS.$s_looped_elements;
										
										$o_z->open($p1_s_dir_src.self::DS.$s_looped_elements);
										
										
										if(!$p4_b_for_keep_arbo)
										{
											for($i=0; $i< $o_z->numFiles; $i++):
											
												
												$a_info=$o_z->statIndex($i);
												
												$s_clean_ds=preg_replace('#[/\\\]#','_', $a_info['name']);
														
												$o_z->renameName($a_info['name'], $s_clean_ds);
													
													if(substr($s_clean_ds, -1, 1) != '_')
													{
														$o_z->extractTo($p2_s_dir_dest, $s_clean_ds);
													}
											endfor;
										
									
										}else $o_z->extractTo($p2_s_dir_dest);
										
									}else $mda_exceptions['ZIPS > '.$p3_i_max_size_zip.' MO'] []= $p1_s_dir_src.self::DS.$s_looped_elements;
								}
								
							}elseif(is_dir($p1_s_dir_src.self::DS.$s_looped_elements) && $s_looped_elements!='.' && $s_looped_elements!='..')
							{
								
								$this->unZipFolders($p1_s_dir_src.self::DS.$s_looped_elements, $p2_s_dir_dest, $p3_i_max_size_zip, $p4_b_for_keep_arbo);
							}
							
						endwhile;
					
					closedir($h_dir);
					
					if(isset($mda_exceptions['ZIPS < '.$p3_i_max_size_zip.' MO']))
                    {
                        return $mda_exceptions;
                        
                    }else return false; 
		
		}
			
			

    /**
     * @return  mixed
     * @param   p1 string filepath to zip source
     * @param   p2 string extraction dir dest
     * @param   p3 boolean to remove first zip
     * @see     that in order to work PERFECTLY the extraction folder must be '.'
     * @see     if you use another type of destination it will work randomly
     * @uses    a swift regexp that is only working on windows system
     * @deprecated  This function is deprecated. Use the next one instead.
     */

	public function unZipZipInZip($p1_s_first_zip, $p2_s_dir_dest='.', $p3_b_for_del_first_zip=false) //ex : => unzip/other_dirs
	{
		
		static $a_zips_in_base_zip, $i_count_recur;
		$i_count_recur++;
		
		$o_z=new ZipArchive;
		
		$o_z->open($p1_s_first_zip);
		
		
			for($i=0; $i< $o_z->numFiles; $i++):
			
				$a_info=$o_z->statIndex($i);
				
				$s_clean_ds=preg_replace('#[/\\\]#','_', $a_info['name']);
				
				$o_z->renameName($a_info['name'] , $s_clean_ds);
				
				
				if(substr($s_clean_ds, -1, 1) !='_')
				{
					$o_z->extractTo($p2_s_dir_dest, $s_clean_ds);
				}	
				
			endfor;
				
		$o_z->close();
			
		
			if(!preg_match('#^[a-zA-Z]{1}:\\\{1}.+$#', $p1_s_first_zip))
			{	
				
				if(!@unlink($p1_s_first_zip)) return FALSE;
				
			}else{ 
				
					if($p3_b_for_del_first_zip)
					{
						if(!@unlink($p1_s_first_zip)) return FALSE;
					}
				}
			
			$h_dir=opendir($p2_s_dir_dest); //ex : => unzip/other_dirs
			
				while($s_looped_elements=readdir($h_dir)):
				
					if(is_file($p2_s_dir_dest.self::DS.$s_looped_elements))  //ex : => unzip/other_dirs/some_file.txt
					{
						$s_ext=$this->strrchr2($s_looped_elements, '.');
					
						if($s_ext == 'zip')
						{
							
							$a_zips_in_base_zip []=$p2_s_dir_dest.self::DS.$s_looped_elements;
								
							//ex : => unzip/other_dirs/some_file.zip  ,  unzip/other_dirs
							$this->unZipZipInZip($p2_s_dir_dest.self::DS.$s_looped_elements, $p2_s_dir_dest, $p3_b_for_del_first_zip);
						}
					}
				endwhile;
				
			closedir($h_dir);
			
			if(count($a_zips_in_base_zip) > 0)
            {
                return $a_zips_in_base_zip;
            
            }else return false;
				
	}
    
    /**
     * @return  multidim array with imbricated zips
     * @see     that in order to work PERFECTLY the extraction folder must be '.'
     * @see     if you use another type of destination it will work randomly
     * @param   p1 string to zip file source
     * @param   p2 string to extraction dir dest
     */
    
    public function unZipZipInZipShorterVersion($p1_s_zip_src, $p2_s_dir_dest = '.')
    {
         static $a_imbricated_zips, $a_any_elements;
        
            $o_zip = new ZipArchive;
        
            if($o_zip->open($p1_s_zip_src)  === TRUE)
            {
                for($i = 0; $i < $o_zip->numFiles; $i++):
                
                    $a_infos_elements = $o_zip->statIndex($i);
                    
                    if($o_zip->extractTo($p2_s_dir_dest, $a_infos_elements ['name'] ) === TRUE)
                    {
                        
                        
                        if(strtolower(strrchr($a_infos_elements ['name'], '.' )) == '.zip')
                        {
                           
                            $a_imbricated_zips ['ZIP'] []  = $a_infos_elements['name'];
                    
                            $this->unZipZipInZipShorterVersion($a_infos_elements['name'], $p2_s_dir_dest);
                            
                        }else $a_any_elements ['! ZIP'] []  = $a_infos_elements ['name']; 
                        
                    }else return FALSE;
                
                endfor;
                
                $o_zip->close();
                
            }else return FALSE;
            
            if(is_array($a_imbricated_zips))
            {
                return $a_imbricated_zips;
                
            }else return $a_any_elements;
    }
	
	
	   /**
        * @return   mixed multidim array on success or boolean false on failure
        * @param    p1 string to dir source
        * @param    p2 string to root dir name in future created zip archive
        * @param    p3 string for zip name created
        * @param    p4 boolean to keep tree file/folder structure
        * @param    p5 integer to archive files under a limit filesize
        * @global   var $o_z must be closed outside the function
        * @see      that file can have the same names in different folders
        */
		

	public function zipTree($p1_s_global_dir, $p2_s_local_dir, $p3_s_zip_name, $p4_b_for_keep_arbo=true, $p5_i_max_filesize=10)
	{
		
			global $o_z;
		
			static $mda_dir_and_files, $i_count_recur;
			
			$i_count_recur++;
			
			if($i_count_recur <= 1)
			{
				$o_z=new ZipArchive;
				$o_z->open($p3_s_zip_name.'.zip', ZIPARCHIVE::CREATE);
				
			}
			
			$h_dir=opendir($p1_s_global_dir);
			
				while($s_looped_elements=readdir($h_dir)):
				
					if(is_file($p1_s_global_dir.self::DS.$s_looped_elements))
					{
						
						if(filesize($p1_s_global_dir.self::DS.$s_looped_elements) / $this->i_diviseur_mo < $p5_i_max_filesize)
						{
							
							$mda_dir_and_files['FILES'] []=$p1_s_global_dir.self::DS.$s_looped_elements;
							
							if($p4_b_for_keep_arbo)
							{
								$o_z->addFile($p1_s_global_dir.self::DS.$s_looped_elements, $p2_s_local_dir.self::DS.$s_looped_elements);
							
							}else $o_z->addFile($p1_s_global_dir.self::DS.$s_looped_elements, str_replace(self::DS, '_', $p1_s_global_dir.self::DS.$s_looped_elements));  
							
						}else $mda_dir_and_files['FILES > '.$p5_i_max_filesize.' MO'] []= $p1_s_global_dir.self::DS.$s_looped_elements;
						
						
					}elseif(is_dir($p1_s_global_dir.self::DS.$s_looped_elements) && $s_looped_elements!='.' && $s_looped_elements!='..')
					{
						
						$mda_dir_and_files['DIRS'] []=$p1_s_global_dir.self::DS.$s_looped_elements;
						
						if(count(scandir($p1_s_global_dir.self::DS.$s_looped_elements)) > 2)
						{
							
							if($p4_b_for_keep_arbo)
							{
								$o_z->addEmptyDir($p2_s_local_dir.self::DS.$s_looped_elements);
								
								$this->zipTree($p1_s_global_dir.self::DS.$s_looped_elements, $p2_s_local_dir.self::DS.$s_looped_elements, $p3_s_zip_name, $p4_b_for_keep_arbo, $p5_i_max_filesize);
								
							}else $this->zipTree($p1_s_global_dir.self::DS.$s_looped_elements, $s_looped_elements, $p3_s_zip_name, $p4_b_for_keep_arbo, $p5_i_max_filesize); 
							
						}
					}
				endwhile;
				
			closedir($h_dir);
			 
			if(count($mda_dir_and_files) > 0)
            { 
                return $mda_dir_and_files;
            
            }else return false; 
	}
	
    /**
     * @return      mixed multidim array on success or bool false on failure
     * @param       p1 string to source dir
     * @see         it is a double recursive function
     * @uses        unZipZipInZipShorterVersion
     */
	
		public function unZipTreeAndRInZip($p1_s_dir_src='.')
		{
			
			static $mda_zips_found;
			
			$h_dir=opendir($p1_s_dir_src);
			
			while($s_looped_elements=readdir($h_dir)):
			
				if(is_file($p1_s_dir_src.RFunk::DS.$s_looped_elements))
				{
					
					$s_ext_file=$this->strrchr2($s_looped_elements, '.');
					
					
					if($s_ext_file == 'zip')
					{
					
						if(filesize($p1_s_dir_src.RFunk::DS.$s_looped_elements) / $this->i_diviseur_mo < 10)
						{
						
							$mda_zips_found['ZIPS < 10 MO'] []= $p1_s_dir_src.RFunk::DS.$s_looped_elements;
						
							$this->unZipZipInZipShorterVersion($p1_s_dir_src.RFunk::DS.$s_looped_elements);
							
						}else{ $mda_zips_found['ZIPS > 10 MO'] []= $p1_s_dir_src.RFunk::DS.$s_looped_elements; }
					}
					
				}elseif(is_dir($p1_s_dir_src.RFunk::DS.$s_looped_elements) && $s_looped_elements !='.' && $s_looped_elements !='..')
				{
					
					$this->unZipTreeAndRInZip($p1_s_dir_src.RFunk::DS.$s_looped_elements);
				}
			
			endwhile;
		
			closedir($h_dir);
			
			if(isset($mda_zips_found['ZIPS < 10 MO']))
            {  
                return $mda_zips_found;  
            
            }else return false; 
			
		}
	/**
     * @name        arbrowser
     * @param       p1 string to source dir
     * @return      string
     */
	public function arbrowser($p1_s_dir_src='.')
	{
		static $sc_arbo;
		global $sc_join_files;
		$i_num_sous_dir=0;
		
		
		$h_dir2=opendir($p1_s_dir_src);
		
		while($s_output_elements2=readdir($h_dir2)):
			
			if(is_dir($p1_s_dir_src.'/'.$s_output_elements2) && $s_output_elements2!='.' && $s_output_elements2!='..')
			{
				$i_num_sous_dir++;
				
			}
		endwhile;
		closedir($h_dir2);
		
		if($p1_s_dir_src == '.') // POUR AFFICHER le dossier '.' en tant que ROOT DIR
		{
			
			if($i_num_sous_dir > 0)
				{
					
					$sc_arbo .= '<li><img src="images/+.jpg" border="none" onclick="switchDisplay(document.getElementById(\''.$p1_s_dir_src.'\'), this);" />&nbsp
								<b><b>ROOT_DIR</b></b></li><ul id="'.$p1_s_dir_src.'" style="display:none;">';
					
				}else{ $sc_arbo .= '<li>'.$p1_s_dir_src.'</li><ul>'; }
			
			
		}else{
			
				$s_last_dir=substr(strrchr($p1_s_dir_src, '/'), 1);
		
				if($i_num_sous_dir > 0)
				{
					
					$sc_arbo .= '<li><img src="images/+.jpg" border="none" onclick="switchDisplay(document.getElementById(\''.$p1_s_dir_src.'\'), this);" />&nbsp
								<b>'.$s_last_dir.'</b></li><ul id="'.$p1_s_dir_src.'" style="display:none;">';
					
				}else $sc_arbo .= '<li>'.$s_last_dir.'></li><ul>'; 
			}
		
		$h_dir=opendir($p1_s_dir_src);
			
			while($s_output_elements=readdir($h_dir)):
			
				if(is_file($p1_s_dir_src.'/'.$s_output_elements))
				{
						$sc_join_files .=$p1_s_dir_src.'/'.$s_output_elements.PHP_EOL;
						
				}elseif(is_dir($p1_s_dir_src.'/'.$s_output_elements) && $s_output_elements != '.'  && $s_output_elements != '..')
				{
					$this->arbrowser($p1_s_dir_src.'/'.$s_output_elements);
				}
			
			endwhile;
		closedir($h_dir);
			
		$sc_arbo .= '</ul>';
		
		return $sc_arbo;
	
	}
	
    /**
     * @name        convertFlashFontSizeToHtmlFontSize
     * @param       p1 string text to modify
     * @param       p2 integer flash font size
     * @param       p3 integer html font size
     * @param       p4 integer incrementor limit
     * @return      string
     */
	public function convertFlashFontSizeToHtmlFontSize($p1_s_txt='', $p2_i_init_flash=8, $p3_i_init_html=1, $p4_i_end_of_flash=15)
	{
		static $a_all_conv;
				
			for(; $p2_i_init_flash < $p4_i_end_of_flash; $p2_i_init_flash++, $p3_i_init_html++):
						
				if(preg_match_all('#SIZE="('.$p2_i_init_flash.')"#',$p1_s_txt, $a_matched_pattern))
				{
					if($s_txt_with_font_conversion=preg_replace('#SIZE="'.$p2_i_init_flash.'"#','SIZE="'.$p3_i_init_html.'"', $p1_s_txt))
					{
						$a_all_conv []=$s_txt_with_font_conversion;
						
						$this->convertFlashFontSizeToHtmlFontSize($s_txt_with_font_conversion, $p2_i_init_flash, $p3_i_init_html, $p4_i_end_of_flash);
						
						break;
					}
				}
				
			endfor;
		
			if(isset($a_all_conv))
			{ 	
				$i_num_keys=count($a_all_conv);
				
				return $a_all_conv[$i_num_keys - 1];
				
			}else return $p1_s_txt; 
	}
	/**
     * @name        xmlRParse
     * @param       p1 string to xml source file
     * @param       p2 object xml (internal parameter)
     * @return      string
     */
	public function xmlRParse($p1_s_xml_file, $p2_o_next_children)
	{
		static $i_num_levels, $sc_arbo_xml;
		
		$i_num_levels++;
		
		if($i_num_levels == 1)
		{
			$s_file = file_get_contents($p1_s_xml_file);
	
			$b_is_utf8_xml = false;
			
			if(preg_match('#&#i', $s_file))
			{
				
				$s_formated_file = str_replace('&', '&amp;', $s_file);
				
			}else $s_formated_file = $s_file;
			
			$p2_o_next_children = simplexml_load_string($s_formated_file);
			
			if(is_object($p2_o_next_children))
			{
				
				if(count($p2_o_next_children->attributes()) > 0)
				{
					
					$sc_arbo_xml = '<font color="blue">
	<span onclick="(document.getElementById(\''.$p2_o_next_children->getName().'\').style.display == \'none\') ? document.getElementById(\''.$p2_o_next_children->getName().'\').style.display = \'block\' : document.getElementById(\''.$p2_o_next_children->getName().'\').style.display = \'none\' ;" style="cursor: pointer;">&lt;'.$p2_o_next_children->getName().' </span>';
	
					foreach($p2_o_next_children->attributes() as $s_att => $s_value_att):
					
						$sc_arbo_xml .=  '<span style="color: #FF0000; cursor: pointer;"
	onclick="modifyAttributesById(\''.$s_att.'\', \''.(string)$s_value_att.'\', document.getElementById(\''.$p2_o_next_children->getName().'_'.$i_num_levels.'_'.$s_att.'_'.(string)$s_value_att.'\').value);">'.$s_att.'</span>
											=<font color="purple">"
											'.$p2_o_next_children->getName().'_'.$i_num_levels.'_'.$s_att.'_'.(string)$s_value_att.'" </font>';
					
					endforeach;
					
					$sc_arbo_xml .=  '<font color="blue">/&gt;</font><ul id="'.$p2_o_next_children->getName().'" style="list-style-type: none;">';
					
				}else
				{
					$sc_arbo_xml = '<font color="blue">
	<span onclick="(document.getElementById(\''.$p2_o_next_children->getName().'\').style.display == \'none\') ? document.getElementById(\''.$p2_o_next_children->getName().'\').style.display = \'block\' : document.getElementById(\''.$p2_o_next_children->getName().'\').style.display = \'none\' ;" style="cursor: pointer;">&lt;'.$p2_o_next_children->getName().'&gt;</span></font>
							<ul id="'.$p2_o_next_children->getName().'" style="list-style-type: none;">';
				
				}
				
			}else return $p2_o_next_children; 
	
		}
		
		foreach($p2_o_next_children->children() as $s_key => $o_value):
	
				if(count($o_value) > 0 && count($o_value->attributes()) > 0)			### IF THE NODE HAS CHILDREN AND ATTRIBUTES IN THE SAME TIME !! ####
				{
					$sc_arbo_xml .=  '<font color="blue">
	<a  onclick="(document.getElementById(\''.$o_value->getName().'_'.$i_num_levels.'\').style.display == \'none\') ? document.getElementById(\''.$o_value->getName().'_'.$i_num_levels.'\').style.display = \'block\' : document.getElementById(\''.$o_value->getName().'_'.$i_num_levels.'\').style.display = \'none\' ;" style="cursor: pointer;">&lt;'.$s_key.'</a>
									</font>';
					
					foreach($o_value->attributes() as $s_att => $s_value_att):
					
						$sc_arbo_xml .=  '<span style="color: #FF0000; cursor: pointer;"
	onclick="modifyAttributesById(\''.$s_att.'\', \''.(string)$s_value_att.'\', document.getElementById(\''.$o_value->getName().'_'.$i_num_levels.'_'.$s_att.'_'.(string)$s_value_att.'\').value);">'.$s_att.'</span>
											=<font color="purple">"
											'.$o_value->getName().'_'.$i_num_levels.'_'.$s_att.'_'.(string)$s_value_att.'" </font>';
					
					endforeach;
					
					$sc_arbo_xml .=  '<font color="blue">/&gt;</font><ul id="'.$o_value->getName().'_'.$i_num_levels.'" style="list-style-type: none;">';
					
					$this->xmlRParse($p1_s_xml_file, $o_value);
					
					$sc_arbo_xml .= '</ul>';
					
					
				}elseif(count($o_value) > 0 && count($o_value->attributes()) == 0)		### IF THE NODE HAD ONLY CHILDREN ###
				{
					
					$sc_arbo_xml .= '<font color="blue">
	<a  onclick="(document.getElementById(\''.$o_value->getName().'_'.$i_num_levels.'\').style.display == \'none\') ? document.getElementById(\''.$o_value->getName().'_'.$i_num_levels.'\').style.display = \'block\' : document.getElementById(\''.$o_value->getName().'_'.$i_num_levels.'\').style.display = \'none\' ;" style="cursor: pointer;">&lt;'.$o_value->getName().'&gt;</font></a>
					<ul id="'.$o_value->getName().'_'.$i_num_levels.'" style="list-style-type: none;">';
					
					$this->xmlRParse($p1_s_xml_file, $o_value); 
					
					$sc_arbo_xml .= '</ul>';
					
					
				}elseif(count($o_value) == 0 && count($o_value->attributes()) == 0)		### IF THE NODE HAS NO CHILDREN OR ATTRIBUTES sample => <pouet/> OR <pouet></pouet>
				{
						if((string)$o_value[0] == '')
						{
							$sc_arbo_xml .= '<li><font color="blue">&lt;/'.$s_key.'&gt;</font></li>';
								
						}else $sc_arbo_xml .=  '<li><font color="blue">&lt;'.$s_key.'&gt;</font>'.$s_key.' '.$o_value.'<font color="blue">&lt;/'.$s_key.'&gt;</font></li>';
						
				}elseif(count($o_value) == 0 && count($o_value->attributes()) > 0)		#### IF THE NODE HAS ATTRIBUTES BUT NO CHILDREN ###
				{
					
					$sc_arbo_xml .=  '<li><font color="blue">&lt;'.$s_key.' </font>';
					
					foreach($o_value->attributes() as $s_att => $s_value_att):
					
						$sc_arbo_xml .=  '<span style="color: #FF0000; cursor: pointer;"
	onclick="modifyAttributesById(\''.$s_att.'\', \''.(string)$s_value_att.'\', document.getElementById(\''.$o_value->getName().'_'.$i_num_levels.'_'.$s_att.'_'.(string)$s_value_att.'\').value);">
						'.$s_att.'</span>=<font color="purple">"'.$o_value->getName().'_'.$i_num_levels.'_'.$s_att.'_'.(string)$s_value_att.'"
						</font>';
					
					endforeach;
					
					$sc_arbo_xml .=  '<font color="blue">/&gt;</font></li>';
					
					
				}
				
		endforeach;
		
		return utf8_decode($sc_arbo_xml).'</ul>';
			
	}
	
	
	/**
 * @author		eclectricmusic
 * @copyright	2009
 * @sample		'$mda_test = array("level_0" => array("file", "file2", "level_1" => array("file3")), "file_of_level0");';
 * 
 *@tutorial		si dans un dossier x il ya un dossier nommé "pouet" et un fichier nommer "test"
 * 				il faut mettre une virgule après "pouet" => array(xxxx), test
 * 
 * 				si dans un dossier x il y a un dossier nommé "pouet" et un fichier nommé "caca"
 * 				il ne faut pas mettre de virgule après "caca", "pouet" => array(xxxx)
 * @see			that this is useful if there is at least 1 file and dir in the current dir !!
 * 
 * 
 * @important	see that this will work as expected
 * 
 * 				=> if('a' < 'z') echo 'lower';
 * 
 * 				whereas  this wont work as expected
 *  				=> if('Z' > 'a') echo 'greater';
 * 
 * @see			that you need to hide the warning of the eval function altought the array is well formed !!!!
 * @return      mixed array or multidim array on success or bool false on failure
 */



	public function treeIntoFakedMultiDimArray($p1_s_dir_src = '.')
	{
		static $sc_tree_files_and_dir;
		
		$h_dir = opendir($p1_s_dir_src);
		
		$i_num_files = $i_num_dirs = 0;
		
		while($s_looped_elements = readdir($h_dir)):
		
			if(is_file($p1_s_dir_src.'/'.$s_looped_elements))
			{
				
				$i_num_files++;
				
				$s_last_file = strtolower($s_looped_elements);
				
				
			}elseif(is_dir($p1_s_dir_src.'/'.$s_looped_elements) && $s_looped_elements != '.' && $s_looped_elements != '..')
			{
				
				$i_num_dirs++;
				$s_last_dir = strtolower($s_looped_elements);
			}
		
		endwhile;
	
		closedir($h_dir);
	
		
		$i_num_files_2 = 0;
		$i_num_dirs_2 = 0;
		
		$h_dir_2 = opendir($p1_s_dir_src);
		
		while($s_looped_elements = readdir($h_dir_2)):
		
			if(is_file($p1_s_dir_src.'/'.$s_looped_elements))			//SAVOIR SI IL Y  A QU UN FICHIER ou UN DOSSIER
			{
				
				$i_num_files_2++;
				
				if($i_num_files == 1 && $i_num_files_2 == 1 && $i_num_dirs > 0)		//si il n'ya qu'1 fichiers MAIS AVEC PLUSIEURS DOSSIERS''
				{
					
					if($s_last_file < $s_last_dir)								//si le nom du dernier fichier et alphabétiquement inférieur au nom du dernier dossier
					{
						$sc_tree_files_and_dir .= '"'.$s_looped_elements.'", ';
						
					}else{ $sc_tree_files_and_dir .= '"'.$s_looped_elements.'"'; }
					
						
				
				}elseif($i_num_files == 1 && $i_num_files_2 == 1)					//si il n'ya qu 1 fichier MAIS SANS AUTRES dossiers !'
				{
						$sc_tree_files_and_dir .= '"'.$s_looped_elements.'"';
				
				}elseif($i_num_files == $i_num_files_2 && $i_num_dirs > 0)		//si ilya plusieurs fichiers qu on est au dernier mais qu il y aussi d autre dossiers !
				{
					if($s_last_file < $s_last_dir)
					{
						$sc_tree_files_and_dir .= '"'.$s_looped_elements.'", ';
						
					}else $sc_tree_files_and_dir .= '"'.$s_looped_elements.'"'; 
				
				}elseif($i_num_files == $i_num_files_2 && $i_num_dirs == 0)			//si il ya plusieurs fichiers et qu'on est au dernier' et qu il n y a pas de dossier
				{
					
						$sc_tree_files_and_dir .= '"'.$s_looped_elements.'"';
						
					
					
				}else	$sc_tree_files_and_dir .= '"'.$s_looped_elements.'", '; 	//si il ya plusieurs fichiers et qu'on est pas encore au dernier'
				
				
			}elseif(is_dir($p1_s_dir_src.'/'.$s_looped_elements) && $s_looped_elements != '.' && $s_looped_elements != '..')
			{
				
				$i_num_dirs_2++;
				
				$sc_tree_files_and_dir .= '"'.$s_looped_elements.'" => array(';
				
				$this->treeIntoFakedMultiDimArray($p1_s_dir_src.'/'.$s_looped_elements);
				
				############### HERE WE NEED TO KNOW IF WE ADD A COMA TO THE NEW ARRAY !!! ################
				
				if($i_num_dirs == 1 && $i_num_dirs_2 == 1 && $i_num_files > 0)			//si il n'ya qu'un dossier mais avec plusieurs fichiers''
				{
					
					if($s_last_dir < $s_last_file)
					{
						
							$sc_tree_files_and_dir .= '), ';
						
					}else 	$sc_tree_files_and_dir .= ')'; 
					
				}elseif($i_num_dirs == 1 && $i_num_dirs_2 == 1)						//si il n y a qu'un dossier sans autres fichiers'
				{
					
					$sc_tree_files_and_dir .= ')';
					
				}elseif($i_num_dirs == $i_num_dirs_2 && $i_num_files > 0)	//si il ya plusieurs dossier et qu on est au dernier MAIS qu il y a aussi d'autre fichiers !'
				{
					
					if($s_last_dir < $s_last_file)
					{
						
							$sc_tree_files_and_dir .= '), ';
						
					}else 	$sc_tree_files_and_dir .= ')'; 	
												
						
				}elseif($i_num_dirs == $i_num_dirs_2 && $i_num_files == 0)	//si il ya plusieurs dossier et qu on est au dernier MAIS qu il n ya PAS d'autre fichiers !'
				{
					
					$sc_tree_files_and_dir .= ')';									
						
				}else $sc_tree_files_and_dir .= '), '; 						// s il ya plusieurs dossiers et qu on est pas encore au dernier !
				
			}
		
		endwhile;
		
		
		closedir($h_dir_2);
		
		if(!empty($sc_tree_files_and_dir))
		{
			@eval('$mda_tree_files_and_dir = array('.$sc_tree_files_and_dir.');');			//NEED TO HIDE, DONT KNOW WHY ???
			
			return $mda_tree_files_and_dir;
			
		}else return false; 
		
		
	}
	
	/**
     * @name        delEmptyDirs
     * @param       p1 string to source dir
     * @uses        two other recursive functions
     * @return      boolean true on success or false on failure
     */
	public function delEmptyDirs($p1_s_dir_src = '.')
	{
	
		if(self::DS == '/')				
		{
			$p1_s_dir_src = str_replace('\\', '/', $p1_s_dir_src); 
	
		}else $p1_s_dir_src = str_replace('/', '\\', $p1_s_dir_src);
			
		$m_output = $this->getDirsPaths($p1_s_dir_src);
			
		if(is_array($m_output))
		{
			
			foreach($m_output as $i_key => $s_empty_path) $this->rmParentDir($s_empty_path);
			
			return true;	
			
		}else return false; 
		
	}
	
	/**
	 * @tutorial	the src array must scans itself foreach elements, maybe TWICE !!!!
	 * @see			that the funk doesnot handle same values found in the array
	 *     			that if you pass a "string int" like this '10000' it will be ranked before 10
     * 			    that the funk doesn not handle float values
     * @param       p1 array
     * @return      mixed multidim array or simple array on success or bool false on failure
	 */
 	
 	 public function simpleRSort(array $p1_mda_disorder)
	 {
	 	
		if(func_num_args() == 1)
	 	{
	 		
	 		if(is_array($p1_mda_disorder))
		 	{
		 		if(count($p1_mda_disorder) > 0)
		 		{
		 			
		 			static $i_count_recursion;
		 			$i_count_recursion++;
	 			
		 			static $mda_all_sorted_haystacks;
		 			
		 		
		 			$i_make_ranking =0;
		 			
		 			foreach($p1_mda_disorder as $m_key => $m_value):							// FIRST LOOP
		 			
		 				
	 					if(count(array_keys($p1_mda_disorder, $m_value)) == 1)
		 				{
							
			 					if(!is_array($m_value))
		 						{
		 			
				 					
				 					foreach($p1_mda_disorder as $m_key_2 => $m_value_2):				// SECOND LOOP
				 					
				 						if(is_resource($m_value_2))
				 						{
				 							echo '<br /> now we dont do anything for the resources';
				 							
				 						}elseif(is_object($m_value_2))
				 						{
				 							echo '<br /> now we dont do anything for the objects';
				 							
				 						}else	//string, int, float, boolet
				 						{
		 								
										 	if($m_value >= $m_value_2)
				 							{
			 								
											 	$i_make_ranking++;
				 								//echo '<br /> <span style="font-size: '.($i_make_ranking * 6).'px;">'.$i_make_ranking.' for '.$m_value.'</span>';
				 								$a_ranked_values [$m_value] = $i_make_ranking;
						 								
						 					}
										
				 						}
				 					
				 					endforeach;
				 					
				 					$i_make_ranking = 0;										//DON'T FORGET TO SET THE COUNTER TO 0 foreach first level values
				 					
								}else	$this->simpleRSort($m_value);	
				 					
		 				}//else return '<font color="red">the input array contains several time this value => '.$m_value.'</font>';
		 			
		 			
		 			endforeach;
		 			
		 		
					
					$i_count_values_second_part = 0;
					
					foreach($p1_mda_disorder as $i_key => $m_value):
					
						$i_count_values_second_part++;
						
					
						foreach($a_ranked_values as $m_key => $i_position):
						
						
							if($i_count_values_second_part == $i_position) $a_sorted [] = $m_key;
							
						endforeach;
						
					endforeach;
				
					
					if($i_count_recursion > 1)
					{
						
						$mda_all_sorted_haystacks [] = $a_sorted;
						return $mda_all_sorted_haystacks;
						
					
					}else return $a_sorted;
				
		 		}else return FALSE;
		 		
		 	}else return FALSE;
		 	
	 	}else return FALSE; 
	
	 }
     
     /**
      * @name       chmodR
      * @param      p1  string to source dir
      * @param      p2 integer to change file mode
     * @return      void
     */
     
    public function chmodR($p1_s_src='.', $p2_i_chmod)
    {
        $h_dir = opendir($p1_s_src);
        
        while($s_elements = readdir($h_dir)):
        
            if(is_file($p1_s_src.self::DS.$s_elements))
            {
                chmod($p1_s_src.self::DS.$s_elements, $p2_i_chmod);
                
            }elseif(is_dir($p1_s_src.self::DS.$s_elements) && $s_elements!= '.' && $s_elements != '..')
            {
                chmod($p1_s_src.'/'.$s_elements, $p2_i_chmod);
                
                $this->chmodR($p1_s_src.self::DS.$s_elements, $p2_i_chmod);
            }
        
        endwhile;
        
        closedir($h_dir);
        
        return;
    }
    
    /**
     * @name        copyTree
     * @param       p1 string to source dir
     * @param       p2  string to destination dir
     * @return      mixed   boolean true on FULL success bool false if dir dest is null or multidim array with file or dir that get error
     */
    
    public function copyTree($p1_s_dir_src = '.', $p2_s_dir_dest = NULL)
    {
        static $a_uncopied_files_or_uncreated_dir;
        
        if($p2_s_dir_dest != NULL)
        {
            $h_dir = opendir($p1_s_dir_src);
            
            while($s_looped_elements = readdir($h_dir)):
            
                if(is_file($p1_s_dir_src.self::DS.$s_looped_elements))
                {
                    if(!copy($p1_s_dir_src.self::DS.$s_looped_elements, $p2_s_dir_dest.self::DS.$s_looped_elements))
                    {
                        $a_uncopied_files_or_uncreated_dir ['ERROR::COPY'] []= $p1_s_dir_src.self::DS.$s_looped_elements;
                    }
                    
                }elseif(is_dir($p1_s_dir_src.self::DS.$s_looped_elements) && $s_looped_elements != '.' && $s_looped_elements !='..')
                {
                    if(mkdir($p2_s_dir_dest.self::DS.$s_looped_elements, 0777))
                    {
                        $this->copyTree($p1_s_dir_src.self::DS.$s_looped_elements, $p2_s_dir_dest.self::DS.$s_looped_elements);
                        
                    }else $a_uncopied_files_or_uncreated_dir ['ERROR::MKDIR'] [] = $p1_s_dir_src.self::DS.$s_looped_elements;
                    
                }
            
            endwhile;
                
            closedir($h_dir);
            
            if(count($a_uncopied_files_or_uncreated_dir) > 0)
            {
                return $a_uncopied_files_or_uncreated_dir;
                
            }else return TRUE;
            
        }else return FALSE;
    }
    

/**
 * @name    isTotalOfAStringOccurencesInATextIsAnEvenOrAnOddNumber
 * @param   p1 mixed needles to be searched
 * @param   p2 string text to search into
 * @return  mixed, array on succes and bool false on failure
 */

public function isTotalOfAStringOccurencesInATextIsAnEvenOrAnOddNumber($p1_m_needle = NULL, $p2_s_haystack = NULL)
{
    static $a_output_result_foreach_searched_string, $i_num_braces, $i_num_brackets, $i_num_parenthesis;

    if(func_num_args() ==  2)
    {
        
        if($p1_m_needle != NULL && $p2_s_haystack != NULL)
        {
            
            if(is_string($p1_m_needle))
            {
                 str_replace($p1_m_needle, '', $p2_s_haystack, $i_count_occurences);
                 
                 
                   
                   if($i_count_occurences > 0)
                    {
                        
                        if($p1_m_needle == '[' || $p1_m_needle == ']')
                        {
                            $i_num_brackets += $i_count_occurences;
                            
                            $a_output_result_foreach_searched_string['[]'] = (is_float($i_num_brackets / 2)) ? 'ODD' : 'EVEN'; 
                            
                        }elseif($p1_m_needle == '(' || $p1_m_needle == ')')
                        {
                            $i_num_parenthesis += $i_count_occurences;
                            
                            $a_output_result_foreach_searched_string['()'] = (is_float($i_num_parenthesis / 2)) ? 'ODD' : 'EVEN';
                            
                        }elseif($p1_m_needle == '{' || $p1_m_needle == '}')
                        {
                            $i_num_braces += $i_count_occurences;
                            
                            $a_output_result_foreach_searched_string['{}'] = (is_float($i_num_braces / 2)) ? 'ODD' : 'EVEN';
                            
                        }else   $a_output_result_foreach_searched_string [$p1_m_needle] = (is_float($i_count_occurences / 2)) ? 'ODD' : 'EVEN';
                        
                   }else $a_output_result_foreach_searched_string [$p1_m_needle] = 'NULL';
                   
                
            }elseif(is_array($p1_m_needle))
            {
                foreach($p1_m_needle as $s_what_needle):
                
                   $this->isTotalOfAStringOccurencesInATextIsAnEvenOrAnOddNumber($s_what_needle, $p2_s_haystack);
                    
                endforeach;
                
            }else return FALSE;
            
        }else return FALSE;
        
    }else return FALSE;
    
    
    if(count($a_output_result_foreach_searched_string) > 0)
    {
        
        return $a_output_result_foreach_searched_string;
        
    }else return FALSE;
}
		############# END OF CLASS ######################
}