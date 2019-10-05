/* http://jsfiddle.net/cM74U/3/ */

jQuery(document).ready(function() {
    URP_AddReviewPieGraph();
});

function URP_AddReviewPieGraph() {
    jQuery('.ewd-urp-pie-graphic').each(function() {
        var canvas = jQuery(this).get(0);  
        var ctx = canvas.getContext("2d"); 

        var rating = jQuery(this).data('reviewscore');

        if (jQuery(this).hasClass('ewd-urp-large-pie')) {
            if (rating.toString().length == 1) {var xTextPos = 53;}
            else if (rating.toString().length == 3) {var xTextPos = 42;}
            else {var xTextPos = 36;}
            ctx.font = "25px Arial"; //turn this into an option
            ctx.fillStyle = ewd_urp_pie_data.circle_graph_fill_color; //99cc33
            ctx.fillText(rating,xTextPos,65);
            var size = "Large";
        }
        else {
            var size = "Small";
        }
    
        URP_drawBack(ctx, size);
        URP_drawRating(ctx, size, rating);
    });
}
    
function URP_drawRating(ctx, size, rating) {   
    ctx.beginPath();
    ctx.strokeStyle = ewd_urp_pie_data.circle_graph_fill_color; //99cc33
    if (size == "Large") {
        ctx.arc(60, 60, 50, 4.71239,rad(rating));
        ctx.lineWidth = 15.0;
    }
    else {
        ctx.arc(22, 22, 17, 4.71239,rad(rating));
        ctx.lineWidth = 10.0;
    }
		ctx.stroke();
} 

function URP_drawBack(ctx, size) {   
    ctx.beginPath();
    ctx.strokeStyle = ewd_urp_pie_data.circle_graph_background_color; //d3d3d3
    if (size == "Large") {
        ctx.arc(60, 60, 50, 0, 6.28319);
        ctx.closePath();
        ctx.lineWidth = 15.0;
    }
    else {
        ctx.arc(22, 22, 17, 0, 6.28319);
        ctx.closePath();
        ctx.lineWidth = 10.0;
    }
	ctx.stroke();
}

function rad(rating) {
    rating = rating/ewd_urp_pie_data.maximum_score*360-90;
    return radians = rating * (Math.PI*2)/360;
}