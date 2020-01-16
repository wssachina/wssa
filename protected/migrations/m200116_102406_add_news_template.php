<?php

class m200116_102406_add_news_template extends CDbMigration {
	public function up() {
		$newsTemplate = new NewsTemplate();
		$newsTemplate->name = '比赛公示及报名';
		$newsTemplate->title_zh = '{$competition->name_zh}公示及报名';
		$newsTemplate->title = '{$competition->name} Announcement and Registration';
		$newsTemplate->content_zh = '{$competition->name_zh}将于{date(\'Y年n月j日\', $competition->date) . ($competition->end_date > 0 ? \'至\' . (date(\'Y\', $competition->date) != date(\'Y\', $competition->end_date) ? date(\'Y年n月j日\', $competition->end_date) : (date(\'n\', $competition->date) != date(\'n\', $competition->end_date) ? date(\'n月j日\', $competition->end_date) : date(\'j日\', $competition->end_date))) : \'\')}在{$competition->location[0]->province ? $competition->location[0]->province->name_zh . $competition->location[0]->city->name_zh : $competition->location[0]->venue_zh}举行。在线报名{$competition->reg_start<=time() ? \'已开放\': date(\'将于m月d日 H:i开放\', $competition->reg_start)}，请点击<a href="{$competition->url}">比赛网站</a>报名及查阅更多相关信息。';
		$newsTemplate->content = '';
		return $newsTemplate->save();
	}

	public function down() {
		return true;
	}
}
