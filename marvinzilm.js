function resizeImageToContainer(image, container, centerVertically) {
	containerHeight = container.height();
	containerWidth = container.width();	
	
	resizeImageToDimensions(image, containerHeight, containerWidth, centerVertically);
}

function resizeImageToDimensions(image, containerHeight, containerWidth, centerVertically) {
	var border = parseInt(image.css("border-left-width"));
	
	imageHeight = image.height();
	imageWidth = image.width();
		
	var scaleHorizontal = (containerWidth - 2*border) / imageWidth;
	var scaleVertical = (containerHeight - 2*border) / imageHeight;
	
	if (scaleHorizontal < scaleVertical) {
		image.removeClass("vertically-limited");
		image.addClass("horizontally-limited");
	} else {
		image.removeClass("horizontally-limited");
		image.addClass("vertically-limited");
	}
	
	if (centerVertically) {
		imageHeight = image.height();
		image.css("margin-top",(containerHeight - border*2 - imageHeight) / 2);	
	}
}

function displayAttachment(attachmentSrc) {
	jQuery(".popup-attachment img").attr("src", attachmentSrc);
	jQuery(".popup-attachment").css("display","block");
	jQuery(".popup-attachment img").one('load', function() {
		var image = jQuery(this);
		var container = image.parent(".popup-attachment");
		resizeImageToContainer(image, container, true);
	}).each(function() {
	  if(this.complete) jQuery(this).load();
	});
	jQuery(".popup-attachment").click(function() {
		window.history.back();
	});
	jQuery(window).one("popstate", function() {
		jQuery(".popup-attachment").css("display","none");
	});
}

function endsWith(str, suffix) {
    return str.indexOf(suffix, str.length - suffix.length) !== -1;
}

jQuery(document).ready(function() {
	var sectionInformation = jQuery("section.information");
	if (sectionInformation)
	{
		jQuery("dd.gallery-caption").each(function(){
			jQuery(this).remove();
			var caption = jQuery(this).html();
			sectionInformation.append("<p>" + caption + "</p>");
		});		
	}
	
	jQuery("img.attachment-thumbnail").one('load', function(){
		var image = jQuery(this);
		resizeImageToDimensions(image, 530, 530);
		image.fadeIn();
	}).each(function(){
		var image = jQuery(this);
		image.css("display","none");
		if (this.complete) jQuery(this).load();
	});

	jQuery("a > img").click(function() {
		var href = jQuery("nav.pagination li.next > a").attr('href');
		if (href)
		{
			location.href = href;			
		}
		/*
		var href=jQuery(this).parent().attr('href');
		if (endsWith(href, ".jpg") || endsWith(href, ".png")) {
			displayAttachment(href);
			window.history.pushState(null, "detail", href);
		} else {
			jQuery.ajax(href)
				.done(function(data) {
					var attachmentSrc = jQuery(data).find("p.attachment a").first().attr('href');
					displayAttachment(attachmentSrc);
				})
				.success(function() {
					window.history.pushState(null, "detail", href);
				});
		}
		*/
		return false;
	});
		
	jQuery(window).resize(function() {
		var image = jQuery(".popup-attachment img");
		var container = image.parent(".popup-attachment");
		resizeImageToContainer(image, container, true);
	});
	
	
	jQuery("section.menu ul li a").mouseover(function(){
		if (!jQuery(this).hasClass("selected")) {			
			jQuery("section.menu ul li a").removeClass("selected");
			jQuery(this).addClass("selected");
					
			var href = jQuery(this).attr("href");
			jQuery.ajax(href).done(function(data) {
				jQuery("section.preview").children().remove();
				image = jQuery(data).find("div.gallery img.attachment-thumbnail").first();
				if (image.length > 0)
				{
					jQuery("section.preview").append(image.hide());
					jQuery("section.preview").removeClass("scrollable");
				}
				else
				{
					preview = jQuery(data).find("section.preview").first();				
					if (preview.length >= 0)
					{
						preview.children().clone().hide().appendTo("section.preview");
						jQuery("section.preview").addClass("scrollable");
					}
				}
				jQuery("section.preview").children().fadeIn();
			});
		}
	});
});
