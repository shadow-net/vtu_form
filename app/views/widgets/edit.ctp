
Skip to content
This repository

    Explore
    Features
    Enterprise
    Pricing

36
678

    180

Datawalke/Coordino

Coordino/app/views/posts/edit.ctp
@Datawalke Datawalke on 9 Jun 2013 PHP 5.4 Support, revised short tags, fixed install process

1 contributor
91 lines (78 sloc) 2.89 KB
<?php
	echo $html->css('wmd.css');
	echo $javascript->link('wmd/showdown.js');
	echo $javascript->link('wmd/wmd.js');
    echo $javascript->link('jquery/jquery.js');
	echo $javascript->link('jquery/jquery.bgiframe.min.js');
	echo $javascript->link('jquery/jquery.ajaxQueue.js');
	echo $javascript->link('jquery/thickbox-compressed.js');
	echo $javascript->link('jquery/jquery.autocomplete.js');
	echo $javascript->link('/tags/suggest');
	echo $html->css('thickbox.css');
	echo $html->css('jquery.autocomplete.css');
?>
    <script>
  $(document).ready(function(){
	$("#resultsContainer").show("blind");
	$("#tag_input").autocomplete(tags, {
		minChars: 0,
		multiple: true,
		width: 350,
		matchContains: true,
		autoFill: false,
		formatItem: function(row, i, max) {
			return row.name + " (<strong>" + row.count + "</strong>)";
		},
		formatMatch: function(row, i, max) {
			return row.name + " " + row.count;
		},
		formatResult: function(row) {
			return row.name;
		}
	});
	$("#PostTitle").blur(function(){
		if($("#PostTitle").val().length >= 10) {
			$("#title_status").toggle();
			getResults();
		} else {
			$("#title_status").show();
		}
	});
	function getResults()
	{
		$.get("/mini_search",{query: $("#PostTitle").val(), type: "results"}, function(data){
			$("#resultsContainer").html(data);
			$("#resultsContainer").show("blind");
		});
	}
	$("#PostTitle").keyup(function(event){
		if($("#PostTitle").val().length < 10) {
			$("#title_status").html('<span class="red">Titles must be at least 10 characters long.</span>');
		} else {
			$("#title_status").html('What is your question about?');
		}
	});
  });
  </script>
<?php
	if(empty($question['Post']['url_title'])) { $question['Post']['url_title'] = 'answer'; }
?>
<h2>Edit<?=(empty($question['Post']['title'])) ? ' Your Answer' : ': ' . $question['Post']['title'];?></h2>

<?=$form->create(null, array(
		'url' => '/questions/' . $question['Post']['public_key'] . '/' . $question['Post']['url_title'] . '/edit')
	); ?>

<?php if ($question['Post']['type'] == 'question') { ?>
<?=$form->label('title');?><br/>

<?=$form->text('title', array('class' => 'wmd-panel big_input', 'value' => $question['Post']['title'], 'id' => 'PostTitle'));?><br/>
<span id="title_status"class="quiet">What is your automotive question about?</span>
<?php } ?>
<div id="wmd-button-bar" class="wmd-panel"></div>
<?=$form->textarea('content', array('id' => 'wmd-input', 'class' => 'wmd-panel', 'value' => $question['Post']['content'])); ?>

<div id="wmd-preview" class="wmd-panel"></div>
<?php if ($question['Post']['type'] == 'question') { ?>
<?=$form->label('tags');?><br/>
<?=$form->text('tags', array('class' => 'wmd-panel big_input', 'value' => $tags, 'id' => 'tag_input'));?><br/>
<span id="tag_status" class="quiet">Combine multiple words into single-words.</span>
<?php } ?>
<br/>
<?=$form->end('Edit');?>

    Status API Training Shop Blog About Pricing 

    © 2015 GitHub, Inc. Terms Privacy Security Contact Help 

