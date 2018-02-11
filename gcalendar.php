<?php
# @ 2018 Vitaliy Zhukov. All rights reserved. Apache License v2.0

# Assert file included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

#Google calendar Content Plugin
class plgContentyoutube extends JPlugin
{

	function PluginGCalendar( &$subject, $params )
	{
		parent::__construct( $subject, $params );
	}

	function onContentPrepare ( $context, &$article, &$params, $page = 0)
		{
		global $mainframe;

		if ( JString::strpos( $article->text, '{youtube}'))
		{
            $article->text = preg_replace_callback('|{gcalendar}(.*){\/gcalendar}|',function ($match){return $this->Calendar($match[1]);}, $article->text);
        }
		return true;
	}

	function Calendar($cid)
	{
	    $config = JFactory::getConfig();
        $params = $this->params;

	 	$width = $params->get('width', 800);
		$height = $params->get('height', 600);
        $scroll = $params->get('scroll', 0);
		$timezone = $config->get('offset');

		if ($scroll){$scroll="yes";} else {$scroll="no";};
		$timezone=urlencode($timezone);
		$cid=urlencode($cid);

        return '<iframe src="https://calendar.google.com/calendar/embed?src='.$cid.'&ctz='.$timezone.'" style="border: 0" width="'.$width.'" height="'.$height.'" frameborder="0" scrolling="'.$scroll.'"></iframe>';
	}
}
