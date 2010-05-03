<?php
require_once('visual_interface.php');

// Standard visualization
class visual implements visual_interface
{
	public function CreatePng($data)
	{
		global $visual_width, $visual_height, $visual_header;
		
		// Create image
		$img = imagecreate($visual_width,$visual_height);

		// set some colors
		$background = imagecolorallocate( $img, 220, 220, 220 );
		$text_color = imagecolorallocate( $img, 0, 0, 0 );
		$line_color = imagecolorallocate( $img, 128, 255, 0 );
		$plot_color = imagecolorallocate( $img, 180, 180, 0 );

		// get min and max
		$min = 0;
		$max = max($data);

		// number of entries
		$numentries=count($data);

		// Fonts
		$font_header=2;
		$font_mark=1;
		$font_footer=1;

		// Font dimensions
		$fontheight_header=imagefontheight($font_header);
		$fontheight_mark=imagefontheight($font_mark);
		$fontheight_footer=imagefontheight($font_footer);

		// set borders
		$border=20;
		$bordertop=4+$fontheight_header;
		$borderbottom=4+$fontheight_footer;

		// Get maxX and maxY
		$maxX=$visual_width-2*$border-2;
		$maxY=$visual_height-$bordertop-$borderbottom-2;
		$singlesizeX=$maxX/$numentries;
		//$singlesizeY=$maxy/$max;

		// Header centerd
		$text_width = imagefontwidth($font_header)*strlen($visual_header);
		$center = ceil($visual_width / 2);
		$x = $center - (ceil($text_width/2));

		// Write header
		imagestring($img, $font_header, $x, 2, $visual_header, $text_color);

		// min and max commit lines
		imageline($img, $border, $bordertop, $visual_width-$border, $bordertop, $line_color);
		imageline($img, $border, $visual_height-$borderbottom, $visual_width-$border, $visual_height-$borderbottom, $line_color);

		// min and max values
		imagestring($img, $font_mark, $border-$fontheight_mark/2, $bordertop-$fontheight_mark/2, $max, $text_color);
		imagestring($img, $font_mark, $border-$fontheight_mark/2, $visual_height-$border-$fontheight_mark/2, $min, $text_color);

		// process entries
		$i=0;
		$lastX=0; // End of last footer

		foreach ($data as $key=>$c)
		{
			// get x coordinates
			$sx=$border+$i*$singlesizeX+2;
			$ex=$sx+$singlesizeX;

			// get y coordinates
			$sy=$bordertop+$maxY-(($c*$maxY)/$max)+2;
			$ey=$bordertop+$maxY;

			// plot rectangle
			imagefilledrectangle($img, $sx, $sy, $ex, $ey, $plot_color);

			// next
			$i++;

			// set footer if it does not overwrite existing one
			if ($sx>$lastX+5)
			{
				$footertextwidth=imagefontwidth($font_footer)*strlen($key);
				if ($sx+$footertextwidth<$border+$maxX)
				{
					$lastX=$sx+$footertextwidth;
					imagestring($img, $font_footer, $sx, $ey+4, $key, $text_color);
				}
			}
		}

		// set image header
		header('Content-type: image/png');

		// Create png
		imagepng($img);
		// deallocate colors
		imagecolordeallocate($img, $line_color);
		imagecolordeallocate($img, $text_color);
		imagecolordeallocate($img, $plot_color);
		imagecolordeallocate($img, $background);

		// cleanup memory
		imagedestroy($img);
	}
}
