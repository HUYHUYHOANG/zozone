<?php
	class CPager
	{
		var $nTotalRows = 0;
		var $nTotalPages = 0;
		var $nOffset = 0;
		var $nStartPos  = 0;
		var $nEndPos = 0;
		var $nStartPage = 0;
		var $nEndPage = 0;		
		var $nPagesPerSeg = 5;
		var $sPrevText = "";
		var $sNextText = "";
		
		public function __construct($nTotalRows, $nOffset, $nRowsPerPage=20, $nPagesPerSeg=5, $prevText="", $nextText="")
		{	
			if(empty($prevText)) $prevText = '<i class="icon-feather-arrow-left"></i>';
			if(empty($nextText)) $nextText = '<i class="icon-feather-arrow-right"></i>';

			$this->sPrevText = $prevText;
			$this->sNextText = $nextText;			
			$this->nTotalRows = $nTotalRows;
			$this->nTotalPages = (($nTotalRows - ($nTotalRows % $nRowsPerPage))/ $nRowsPerPage) + ($nTotalRows % $nRowsPerPage ? 1 : 0);			
			$this->nPagesPerSeg = is_numeric($nPagesPerSeg) ? $nPagesPerSeg : 5;

			//validate offset
			if($nOffset < 1){
				$nOffset = 1;
			}elseif($nOffset > $this->nTotalPages){
				$nOffset = $this->nTotalPages;
			}
			
			$this->nStartPos = ($nOffset - 1) * $nRowsPerPage;
			$this->nEndPos = $this->nStartPos + $nRowsPerPage - 1;
			if($this->nEndPos >= $nTotalRows)
				$this->nEndPos = $nTotalRows - 1;
			
			$nCurrentSeg = (($nOffset - ($nOffset % $this->nPagesPerSeg)) / $this->nPagesPerSeg) + ($nOffset % $this->nPagesPerSeg ? 1 : 0);
			$this->nStartPage = ($nCurrentSeg - 1) * $this->nPagesPerSeg + 1;
			$this->nEndPage = $this->nStartPage + $this->nPagesPerSeg - 1;
			if($this->nEndPage > $this->nTotalPages)
				$this->nEndPage = $this->nTotalPages;
			
			//save offset
			$this->nOffset = $nOffset;
			
		}
		
		public function begin(){ return $this->nStartPos;}
		public function pages(){ return $this->nTotalPages;}
		
		public function show($className, $currPageColor, $viewDetail=1, $seekCallback=null, $output=1){
			return $this->_render($className, $currPageColor, $viewDetail, $seekCallback, $output);
		}		
		private function _render($className, $currPageColor, $viewDetail=1, $seekCallback=null, $output=1){
			if(!$this->nTotalRows)
				return;
			if(!$seekCallback)
				$seekCallback = "gotoPage";
			
			$szPaging = "";
			$text = " ";			
			if($viewDetail)
			 	$text = "<span>" . ($this->nStartPos + 1) . "-" . ($this->nEndPos+1) . "/" . number_format($this->nTotalRows) . "</span>&nbsp;-&nbsp;" . $text;
				
			$szPaging .= $text;
			if($this->nTotalPages==1){
				if($output)
					echo $szPaging;
				return $szPaging;
			}

			if($this->nOffset>1)
				$szPaging .= "<a class='$className' href='javascript:void(0);' onclick='$seekCallback(" . ($this->nOffset - 1) . ");return false;'>" . $this->sPrevText . "</a>";

			if($this->nStartPage == $this->nEndPage){
				$start = $this->nEndPage - $this->nPagesPerSeg;
				$start = $start >= 1 ? $start : 1;

				if($start > 1){
					$szPaging .= " <a class='$className' href='javascript:void(0);' onclick='$seekCallback(1);return false;'>1</a>";
					$szPaging .= sprintf(" <a class='$className' href='javascript:void(0);' onclick='$seekCallback(%d);return false;'>...</a> ", $start-1);
				}
				for($i=$start; $i<$this->nEndPage; ++$i){
					$szPaging .= sprintf(" <a class='$className' href='javascript:void(0);' onclick='$seekCallback(%d);return false;'>%d</a>", $i, $i);
				}
				$szPaging .= " <a class='$className current' style='color:$currPageColor;cursor:default;'>" . $this->nStartPage . "</a> ";
			}
			else{
				if($this->nStartPage > 1){					
					$szPaging .= " <a class='$className' href='javascript:void(0);' onclick='$seekCallback(1);return false;'>1</a> ";
					$szPaging .= sprintf(" <a class='$className' href='javascript:void(0);' onclick='$seekCallback(%d);return false;'>...</a> ", $this->nStartPage-1);
					if($this->nOffset==$this->nStartPage)
						$szPaging .= " <a class='$className' href='javascript:void(0);' onclick='$seekCallback(" . ($this->nStartPage-1) . ");return false;'>" . ($this->nStartPage-1) ."</a> ";
				}
								
				for($index = $this->nStartPage; $index <= $this->nEndPage; ++$index){
					if($index != $this->nOffset)					
						$szPaging .= sprintf(" <a class='$className' href='javascript:void(0);' onclick='$seekCallback(%d);return false;'>%d</a>",
									  $index, $index, $index);
					else
						$szPaging .= " <a class='$className current' style='color:$currPageColor;cursor:default;'>" . $index . "</a>";
					if($index==$this->nEndPage)
						$szPaging .= " ";
				}
				
				if($this->nEndPage < $this->nTotalPages){
					if($this->nOffset==$this->nEndPage && $this->nEndPage+1!=$this->nTotalPages)
						$szPaging .= sprintf(" <a class='$className' href='javascript:void(0);' onclick='$seekCallback(%d);return false;'>%d</a> ", $this->nEndPage+1, $this->nEndPage+1);					
					if($this->nEndPage<$this->nTotalPages-1)
						$szPaging .= sprintf(" <a class='$className' href='javascript:void(0);' onclick='$seekCallback(%d);return false;'>...</a> ", $this->nEndPage+1);
					if($this->nEndPage+1<=$this->nTotalPages)
						$szPaging .= "<a class='$className' href='javascript:void(0);' onclick='" . $seekCallback . "(" . $this->nTotalPages . ");return false;'>" . $this->nTotalPages . "</a>";
				}
			}
			
			if($this->nOffset<$this->nTotalPages)
				$szPaging .= " <a class='$className' href='javascript:void(0);' onclick='$seekCallback(" . ($this->nOffset + 1) . ");return false;'> " . $this->sNextText . "</a> ";
			if($output)
				echo $szPaging;
			return $szPaging;
		}//_render
		
		public function renderRewrite($className, $currPageColor, $viewDetail=1, $url="", $output=1){
			if(!$this->nTotalRows)
				return;
			
			$szPaging = "";
			$text = " ";			
			if($viewDetail)
			 	$text = "<font color='#0000AA'>" . ($this->nStartPos + 1) . "-" . ($this->nEndPos+1) . "/" . $this->nTotalRows . "</font> " . $text;
				
			$szPaging .= $text;
			if($this->nTotalPages==1){
				if($output) echo $szPaging;
				return $szPaging;
			}

			if($this->nOffset>1) $szPaging .= sprintf("<a class='$className' href='%s/%d.html'>%s</a>", $url, $this->nOffset - 1, $this->sPrevText);

			if($this->nStartPage == $this->nEndPage){
				$start = $this->nEndPage - $this->nPagesPerSeg;
				$start = $start >= 1 ? $start : 1;

				if($start > 1){
					$szPaging .= " <a class='$className' href='".$url."/1.html'>1</a>";
					$szPaging .= sprintf(" <a class='$className' href='%s/%d.html'>...</a> ", $url, $start-1);
				}
				for($i=$start; $i<$this->nEndPage; ++$i){
					$szPaging .= sprintf(" <a class='$className' href='%s/%d.html'>%d</a>", $url, $i, $i);
				}
				$szPaging .= " <a class='$className' style='color:$currPageColor;cursor:default;'>" . $this->nStartPage . "</a> ";
			}
			else{
				if($this->nStartPage > 1){					
					$szPaging .= " <a class='$className' href='".$url."/1.html'>1</a> ";
					$szPaging .= sprintf(" <a class='$className' href='%s/%d.html'>...</a> ", $url, $this->nStartPage-1);
					if($this->nOffset==$this->nStartPage)
						$szPaging .= sprintf(" <a class='$className' href='%s/%d.html'>%d</a>", $url, $this->nStartPage-1, $this->nStartPage-1);
				}
								
				for($index = $this->nStartPage; $index <= $this->nEndPage; ++$index){
					if($index != $this->nOffset)					
						$szPaging .= sprintf(" <a class='$className' href='%s/%d.html'>%d</a>", $url, $index, $index);
					else
						$szPaging .= " <a class='$className' style='color:$currPageColor;cursor:default;'>" . $index . "</a>";
					if($index==$this->nEndPage)
						$szPaging .= " ";
				}
				
				if($this->nEndPage < $this->nTotalPages){
					if($this->nOffset==$this->nEndPage && $this->nEndPage+1!=$this->nTotalPages)
						$szPaging .= sprintf(" <a class='$className' href='%s/%d.html'>%d</a> ", $url, $this->nEndPage+1, $this->nEndPage+1);
					if($this->nEndPage<$this->nTotalPages-1)
						$szPaging .= sprintf(" <a class='$className' href='%s/%d.html'>...</a> ", $url, $this->nEndPage+1);
					if($this->nEndPage+1<=$this->nTotalPages)
						$szPaging .= sprintf("<a class='$className' href='%s/%d.html'>%d</a>", $url, $this->nTotalPages, $this->nTotalPages);
				}
			}
			
			if($this->nOffset<$this->nTotalPages)
				$szPaging .= sprintf(" <a class='$className' href='%s/%d.html'>%s</a>", $url, $this->nOffset + 1, $this->sNextText);
			if($output) echo $szPaging;
			return $szPaging;
		}//rewrite mod
		
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//bootstrap style
		public function renderBootstrapStyle($class, $simple=0){
			if(!$this->nTotalRows || $this->nTotalPages==1)
				return;
			
			echo sprintf("<ul class='%s'>", $class);

			if($this->nOffset>1) echo sprintf("<li><a data-page='%d'>%s</a></li>", $this->nOffset - 1, $this->sPrevText);
			else echo sprintf("<li class='disabled'><a>%s</a></li>", $this->sPrevText);
			if(!$simple){
				if($this->nStartPage == $this->nEndPage){
					$start = $this->nEndPage - $this->nPagesPerSeg;
					$start = $start >= 1 ? $start : 1;
	
					if($start > 1){
						echo "<li><a data-page='1'>1</a></li>";
						echo sprintf("<li><a data-page='%d'>...</a></li>", $start-1);
					}
					for($i=$start; $i<$this->nEndPage; ++$i){
						echo sprintf("<li><a data-page='%d'>%d</a></li>", $i, $i);
					}
					echo sprintf("<li class='active'><a>%d</a></li>", $this->nStartPage);
				}
				else{
					if($this->nStartPage > 1){
						echo "<li><a data-page='1'>1</a></li>";
						echo sprintf("<li><a data-page='%d'>...</a></li>", $this->nStartPage-1);
						if($this->nOffset==$this->nStartPage)
							echo sprintf("<li><a data-page='%d'>%d</a></li>", $this->nStartPage-1, $this->nStartPage-1);
					}
									
					for($index = $this->nStartPage; $index <= $this->nEndPage; ++$index){
						if($index != $this->nOffset)					
							echo sprintf("<li><a data-page='%d'>%d</a></li>", $index, $index);
						else
							echo sprintf("<li class='active'><a>%d</a></li>", $index);
						//if($index==$this->nEndPage) echo " ";
					}
					
					if($this->nEndPage < $this->nTotalPages){
						if($this->nOffset==$this->nEndPage && $this->nEndPage+1!=$this->nTotalPages)
							echo sprintf("<li><a data-page='%d'>%d</a></li>", $this->nEndPage+1, $this->nEndPage+1);
						if($this->nEndPage<$this->nTotalPages-1)
							echo sprintf("<li><a data-page='%d'>...</a></li>", $this->nEndPage+1);
						if($this->nEndPage+1<=$this->nTotalPages)
							echo sprintf("<li><a data-page='%d'>%d</a></li>", $this->nTotalPages, $this->nTotalPages);
					}
				}
			}
			
			if($this->nOffset<$this->nTotalPages) echo sprintf("<li><a data-page='%d'>%s</a></li>", $this->nOffset + 1, $this->sNextText);
			else echo sprintf("<li class='disabled'><a>%s</a></li>", $this->sNextText);
			echo "</ul>";
		}//rewrite bootstrap style
	}//class
?>