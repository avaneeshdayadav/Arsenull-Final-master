function textareaHandle()
{
	textarea = document.querySelectorAll(".autoresizing"); 
    for(var i=0;i<textarea.length;i++)
    textarea[i].addEventListener('input', autoResize, false); 
}

function autoResize() { 
    this.style.height = 'auto'; 
    this.style.height = this.scrollHeight + 'px'; 
} 

function getName(evt)
{
	alert($(evt).attr("id"));
}

function nameSec()
{
	var allSec=document.querySelectorAll('.section')
	for(var i=1;i<allSec.length;i++)
	{
		// secName='sec_'.concat(i);
		$(allSec[i]).attr("id",i);
	}
}

function nameQnCard(section)
{
	var allQns=section.find('.qncard');
	for(var i=0;i<allQns.length;i++)
	{
		num=i+1;
		// qnName='qn_'.concat(num);
		$(allQns[i]).attr("id",num);
		$(allQns[i]).find('.qnNoSpan').text(num);
	}	
}

function nameOpts(qncard)
{
	var allOpts=qncard.find('.option');
	var allCorrectOpt=qncard.find('.sub');

	// If only one option then don't allow delete of option.
		if(allOpts.length==1)
		{
			allOpts.find('.cutBtn').css('display','none');
		}
		else
		{
			allOpts.find('.cutBtn').css('display','inline');
		}
	// If only one option then don't allow delete of option end.

	for(var i=0;i<allOpts.length;i++)
	{
		num=i+1;
		// optName='opt_'.concat(num);
		$(allOpts[i]).attr("id",num);
	}	
}

function createSec()
{
	var newSec=$("#section").clone().appendTo( "#main" );
	nameSec();
	textareaHandle();

	// Data for php page.
		var secNo=newSec.attr('id');
	// Data for php page end.

	// Ajax.
		$.ajax({
			url: "insert_test_data_on_element_creation.php",
			type: 'POST',
			data: {'inpType':"S", 'testId':testId, 'secNo':secNo },
			async: true,
		});		
	// Ajax end.
}

function createAndAddQn(section)
{
	var secQnsDiv=section.find('.secQns');
	var newQnCard=$('#qncard').clone().appendTo(secQnsDiv);
	nameQnCard(section);

	$([document.documentElement, document.body]).animate({
    scrollTop: $(newQnCard).offset().top
	}, 200);

	textareaHandle();

	// Data for php page.
		var secNo=section.attr('id');
		var qnNo=newQnCard.attr('id');
	// Data for php page end.

	// Ajax.
		$.ajax({
			url: "insert_test_data_on_element_creation.php",
			type: 'POST',
			data: {'qnNo':qnNo, 'inpType':"Q",'testId':testId, 'secNo':secNo },
			async: true,
		});		
	// Ajax end.

	createAndAddOpt(newQnCard);

}

function createNextQn(qnLinkBtns)
{
	var section=qnLinkBtns.parent().parent().parent();
	var newQnCard=$('#qncard').clone();
	qnLinkBtns.parent().after(newQnCard);
	nameQnCard(section);

	//Scroll to new card
	$([document.documentElement, document.body]).animate({
    scrollTop: $(newQnCard).offset().top
	}, 200);

	// Data for php page.
		var secNo=section.attr('id');
		var qnNo=newQnCard.attr('id');
	// Data for php page end.

	// Ajax.
		$.ajax({
			url: "insert_test_data_on_element_creation.php",
			type: 'POST',
			data: {'qnNo':qnNo, 'inpType':"NQ",'testId':testId, 'secNo':secNo },
			async: true,
		});
	// Ajax end.

	createAndAddOpt(newQnCard);


}

function createAndAddOpt(qncard)
{
	var newOpt=$('#option').clone().appendTo(qncard.find('.qnOptns'));

	nameOpts(qncard);
	textareaHandle();

	// // Data for php page.
		var qnNo=qncard.attr('id');
		var secNo=qncard.parent().parent().attr('id');
		var optNo=newOpt.attr('id');
	// // Data for php page end.

	// Ajax.
		$.ajax({
			url: "insert_test_data_on_element_creation.php",
			type: 'POST',
			data: {'qnNo':qnNo, 'inpType':"O",'testId':testId, 'secNo':secNo, 'optNo':optNo },
			async: true,
		});
	// Ajax end.
}

function delOpt(option)
{
	var optNo=option.attr('id');
	var qncard=option.parent().parent();
	var qnNo=qncard.attr('id');
	var secNo=option.parent().parent().parent().parent().attr('id');
	var allOpts=option.parent().parent().parent().find('.option');

	// Ajax.
		$.ajax({
			url: "test_element_data_deletion.php",
			type: 'POST',
			data: {'qnNo':qnNo, 'inpType':"O",'testId':testId, 'secNo':secNo, 'optNo':optNo },
			async: true,
		});
	// Ajax end.


	if(allOpts.length>1)
		option.remove();

	nameOpts(qncard);
}

function delQn(qncard)
{
	var section=qncard.parent().parent();
	var qnNo=qncard.attr('id');
	var secNo=section.attr('id');
	var allQns=section.find('.qncard');

	// Ajax.
		$.ajax({
			url: "test_element_data_deletion.php",
			type: 'POST',
			data: {'qnNo':qnNo, 'inpType':"Q",'testId':testId, 'secNo':secNo },
			async: true,
		});
	// Ajax end.


	qncard.remove();
	nameQnCard(section);

}

function showImgIcon(evt)
{
	var allImgInp=document.querySelectorAll(".inpFieldRow");
	for(var i=0;i<allImgInp.length;i++)
	{
		$(allImgInp[i]).find(".imgBtn").css("display","none");
	}
	var imgIcon=$(evt).find(".imgBtn");
	imgIcon.css( "display", "block" );

}

function addImg(evt)
{
	$(evt).parent().find(".imgInp").trigger('click');

	// To ge image preview
    function readURL(input)
    {
		if (input.files && input.files[0])
		{
			var reader = new FileReader();
		    
	    	reader.onload = function(e)
	    	{
	    		var imgToShow=$(evt).parent().parent().parent().parent().find("#imgShow");
		    	$(imgToShow).attr('src', e.target.result);
		    }
		    
		    reader.readAsDataURL(input.files[0]); // convert to base64 string
		}
	}

	var input=$(evt).parent().find(".imgInp");
	$(input).change(function()
	{
	  readURL(this);
	  $(evt).parent().parent().parent().parent().children(".imgSec").css("display","block");
	});


	// To ge image preview is end here.	
}


function highlight(evt)
{
	var questions=document.querySelectorAll(".qncard");
	for(var i=0;i<questions.length;i++)
	{
		$(questions[i]).css("border-left-width","0");
		$(questions[i]).find(".qnLinkBtns").css("display","none");
	}
	$(evt).find(".qnLinkBtns").css("display","flex");
	$(evt).css("border-left-width","6px");
	$(evt).css("border-left-color","#689ff7");
	textareaHandle();
}

function toggleCheckmarkColor(evt)
{
	var correctFlag;
	var optNo=$(evt).parent().parent().parent().attr('id');
	var secNo=$(evt).parent().parent().parent().parent().parent().parent().parent().attr('id');
	var qnNo=$(evt).parent().parent().parent().parent().parent().attr('id');

	if($(evt).find('.checkmark_circle').css('background-color')=="rgb(128, 128, 128)")
	{
		$(evt).find('.checkmark_circle').attr('id','greenNow');
		correctFlag=1;
	}
	else
	{
		$(evt).find('.checkmark_circle').attr('id','greyNow');
		correctFlag=0;
	}

	// Ajax.
		$.ajax({
			url: "dyanamic_upload.php",
			type: 'POST',
			data: {'correctFlag':correctFlag, 'inpType':"CM", 'testId':testId, 'secNo':secNo, 'qnNo':qnNo, 'optNo':optNo },
			async: true,
		});
	// Ajax end.



}


// $( window ).resize(function() {
//     if (document.documentElement.clientWidth > 800 )
//     {
//         $(".deskSidenav").css("width","19vw");
//         $(".transparent").css("display","none");
//     }
//     else if (document.documentElement.clientWidth < 800 )
//     {
//         $(".deskSidenav").css("width","0vw");
//     }

// });




function uplQn(qncard)
{
	var qnNo=qncard.attr('id');
	var question=qncard.find('.question').val();
	var secNo=qncard.parent().parent().attr('id');

	// Ajax.
		$.ajax({
			url: "dyanamic_upload.php",
			type: 'POST',
			data: {'question':question, 'inpType':"Q",'testId':testId, 'secNo':secNo, 'qnNo':qnNo },
			async: true,
		});

	// Ajax end.
}

function uplOpt(optCard)
{
	var qnNo=optCard.parent().parent().attr('id');
	var secNo=optCard.parent().parent().parent().parent().attr('id');
	var optInp=optCard.find('.optInp').val();
	var optNo=optCard.attr('id');

	// Ajax.
	$.ajax({
		url: "dyanamic_upload.php",
		type: 'POST',
		data: {'optInp':optInp, 'inpType':"O",'testId':testId, 'secNo':secNo, 'qnNo':qnNo, 'optNo':optNo },
		async: true,

	});
	// Ajax end.



}

$(document).ready(function(){

	// Ajax.
		$.ajax({
			url: "test_draft_data.php",
			type: 'POST',
			data: {'testId':1},
			dataType: "json",
			async: true,
			success:function(ultra)
			{
				alert(ultra.status);
				if(ultra.status == 'ok')
				{
					var allSec=ultra.sec;
					$.each(allSec, function(secNo, oneSec){
						var unitName=oneSec.unitName;
						var cumpNoOfQn=oneSec.cumpNoOfQn;

						// Create and fill section.
							var newSec=$("#section").clone().appendTo( "#main" );
							nameSec();
							textareaHandle();

							newSec.find('.chapterORunit').val(unitName);
							newSec.find('.noOfQnToAsk').val(cumpNoOfQn);
						// Create and fill section end.						

						var allQn=oneSec.allQn;
						$.each(allQn,function(qnNoIndex,oneQn) {
							var question=oneQn.question;
							var qnImg=oneQn.qnImg;
							var qnNo=oneQn.qnNo;

						// Create and fill thisQn.
							var secQnsDiv=newSec.find('.secQns');
							var newQnCard=$('#qncard').clone().appendTo(secQnsDiv);
							nameQnCard(newSec);				
							textareaHandle();
							newQnCard.find('.question').val(question);
							newQnCard.find('.qnNoSpan').text(qnNo);
						// Create and fill thisQn end.						

							var allOpt=oneQn.allOpt;
							$.each(allOpt,function(optNo,oneOpt){
								var optInp=oneOpt.optInp;
								var optImg=oneOpt.optImg;
								var correctFlag=Number(oneOpt.correctFlag);

								// Create and fill thisOpt.
									var newOpt=$('#option').clone().appendTo(newQnCard.find('.qnOptns'));
									newOpt.find('.optInp').val(optInp);
									nameOpts(newQnCard);
									textareaHandle();
									if(correctFlag==1)
									{
										newOpt.find('.checkmark_circle').attr('id','greenNow');
									}
								
								// Create and fill thisOpt end.
											
							});
						});
					});
				}
				else
				{
					createSec();
				}

			},
			error: function (jqXhr, textStatus, errorMessage)
			{ // error callback 
				alert(errorMessage);
				//console.error(this.props.url, status, err.toString());
				console.warn(xhr.responseText);
			}
		});
	// Ajax end.

	// createSec();

});

function uplChapter(section) {
	var secNo=section.attr('id');
	var unitName=section.find('.chapterORunit').val();

	// Ajax.
		$.ajax({
			url: "dyanamic_upload.php",
			type: 'POST',
			data: {'unitName':unitName, 'inpType':"U",'testId':testId, 'secNo':secNo },
			async: true,
		});

	// Ajax end.
	
}

function uplNoOfQnToAsk(section)
{
	var secNo=section.attr('id');
	var cumpNoOfQn=section.find('.noOfQnToAsk').val();

	// Ajax.
		$.ajax({
			url: "dyanamic_upload.php",
			type: 'POST',
			data: {'cumpNoOfQn':cumpNoOfQn, 'inpType':"NQA",'testId':testId, 'secNo':secNo },
			async: true,
		});

// Ajax end.
	
}

function uplQnImg(qnImg)
{
	var thisQnCard=$(qnImg).parent().parent().parent().parent().parent().parent();
	var thisSec=$(qnImg).parent().parent().parent().parent().parent().parent().parent().parent()
	var qnNo=thisQnCard.attr('id');
	var secNo=thisSec.attr('id');

	// check if not empty.
	if(thisQnCard.find("input[name='qnImg']").val()!="")
	{
		var qnImgInp=thisQnCard.find("input[name='qnImg']")[0].files[0];
		const fileType = qnImgInp['type'];
		const validImageTypes = ['image/gif', 'image/jpeg', 'image/png','image/jpg'];
		// Check if input file is image file.
		if (!validImageTypes.includes(fileType))
		{
			alert("File is not an image.");
		}
		else
		{
			var fd = new FormData();
				fd.append('qnNo',qnNo);
				fd.append('secNo',secNo);
				fd.append('inpType',"QI");
				fd.append('qnImgInp',qnImgInp);
				fd.append('testId',testId);

			//Ajax claa send img file.
				$.ajax({
					url: "dyanamic_upload.php",
					type: 'POST',
					data: fd,
					contentType: false,
					processData: false,
					success:function(data)
					{
						alert(data);
					}
				});
			//Ajax claa send img file.
		}
	}

}