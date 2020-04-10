<?php

Class DataMining
{
	/**
	 * Because the problem of array storage for Point, so, a vector is formated in String format. Each byte is a value ^^.
	 * This function will calculate the cosinesimilarity between 2 vector in string format.
	 */
	public static function cosineSimilarity($a, $b, $precision = 8)
	{
		$sim = 0;

		if(is_array($a) && is_array($b))
		{
			$n = count($a);

			//Calculate Tu
			$t = 0;
				
			//calculate Mau
			$m1 = $m2 = 0;
//			for($i = 0; $i < $n; $i++)
//			{
//				$t += $a[$i] * $b[$i];
//
//				$m1 += $a[$i] * $a[$i];
//				$m2 += $b[$i] * $b[$i];
//			}
			foreach($a  as $k=>$v)
			{
				$t  += $v * $b[$k];

				$m1 += $v * $v;
				$m2 += $b[$k] * $b[$k];
			}


			$m = sqrt($m1) * sqrt($m2);
			if($m != 0)
			{
				$sim = round($t / $m, $precision);
			}


		}
		elseif(strlen($a) == strlen($b))
		{
			$n = strlen($a);

			//Calculate Tu
			$t = 0;
				
			//calculate Mau
			$m1 = $m2 = 0;
			for($i = 0; $i < $n; $i++)
			{
				$t += $a[$i] * $b[$i];
				$m1 += $a[$i] * $a[$i];
				$m2 += $b[$i] * $b[$i];
			}
			
			$m = sqrt($m1) * sqrt($m2);
			if($m != 0)
			{
				$sim = round($t / $m, $precision);
			}
		}
		
		return $sim;
	}
	
	/**
	 * Calculate Pearson Correlation, use formular at http://www.trialrun.com/pop-ups/pearsons_correlation.html
	 */
	public static function pearsonCorrelation($a, $b, $precision = 8)
	{
		$r = 0;
		
		if(is_array($a) == is_array($b))
		{
			$n = count($a);
			
			//Calculate T
			$t = 0;
			$t1 = 0; //EXY
			$t21 = 0; //EX
			$t22 = 0; //EY
			
			//Calculate M
			$m = 0;
			$m11 = 0; 	//EX2
			$m12 = 0;	//EX
			$m21 = 0;	//EY2
			$m22 = 0;	//EY
			for($i = 0; $i < $n; $i++)
			{
				$t1 += $a[$i] * $b[$i];
				$t21 += $a[$i];
				$t22 += $b[$i];
				
				$m11 += (int)$a[$i] * (int)$a[$i];
				$m21 += (int)$b[$i] * (int)$b[$i];
			}
			
			$t = $t1 - $t21 * $t22 / $n;
			$m = sqrt(($m11 - $t21 * $t21 / $n) * ($m21	 - $t22 * $t22 / $n));
			if($m != 0)
				$r = round($t/$m, $precision);
		}
		elseif(strlen($a) == strlen($b))
		{
			$n = strlen($a);
			
			//Calculate T
			$t = 0;
			$t1 = 0; //EXY
			$t21 = 0; //EX
			$t22 = 0; //EY
			
			//Calculate M
			$m = 0;
			$m11 = 0; 	//EX2
			$m12 = 0;	//EX
			$m21 = 0;	//EY2
			$m22 = 0;	//EY
			for($i = 0; $i < $n; $i++)
			{
				$t1 += $a[$i] * $b[$i];
				$t21 += $a[$i];
				$t22 += $b[$i];
				
				$m11 += (int)$a[$i] * (int)$a[$i];
				$m21 += (int)$b[$i] * (int)$b[$i];
			}
			
			$t = $t1 - $t21 * $t22 / $n;
			$m = sqrt(($m11 - $t21 * $t21 / $n) * ($m21	 - $t22 * $t22 / $n));
			if($m != 0)
				$r = round($t/$m, $precision);
		}
		
		return $r;
	}
	
	/**
	 * Jaccard Coefficient, Jaccard Index, Jaccard Similarity..Best for Binary Rating system (1 or 0, Like, Dislike..)
	 */
	public static function jaccardCoefficient($a, $b, $precision = 8)
	{
		$r = 0;
		
		if(strlen($a) == strlen($b))
		{
			$n = strlen($a);
			
			$m11 = 0;
			$m10 = 0;
			$m01 = 0;
			for($i = 0; $i < $n; $i++)
			{
				$k = (int)$a[$i];
				$l = (int)$b[$i];
				
				if($k == $l && $k == 1)
					$m11++;
				elseif($k == 1)
					$m10++;
				elseif($l == 1)
					$m01++;
			}
			
			if(($m11 + $m10 + $m01) != 0)
				$r = $m11 / ($m11 + $m10 + $m01);
		}
		
		return $r;
	}
}