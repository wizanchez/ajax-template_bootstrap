<?php
class Fjvm_mensaje
{
	
	public function mensaje_error($TEXT)
	{
		?><table  align="center" border="0" cellspacing="0" cellpadding="00"><tr><?php
			?><td bgcolor="#FFFFFF"><img src="images_design/errorrr.png" /></td><?php
			?><td style="font-family:Verdana, Geneva, sans-serif; font-size:13px; color:#000; background-color:#FFF; cursor:pointer;" align="center"><?=$TEXT?></td><?php
			  ?></tr></table><?php

		 }
	
	public function mensaje_si($TEXT)
	{
	?><table  align="center" border="0" cellspacing="0" cellpadding="00"><tr><td bgcolor="#FFFFFF"><img src="images_design/Protection.png" border="0" width="40" height="40" /></td><td style="font-family:Verdana, Geneva, sans-serif; font-size:13px; color:#000; background-color:#FFF; cursor:pointer;" align="center"><?=$TEXT?></td></tr></table><? }
	
	
	}


?>