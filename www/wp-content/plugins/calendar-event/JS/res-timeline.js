(function(jQuery){
	jQuery.fn.jflatTimeline = function(options){
		/**------------------ SETTING PARAMETERS ------------------**/
		var timelinedates = new Array();
		var date_sort_asc = function (date1, date2) {
			// This is a comparison function that will result in dates being sorted in
			// ASCENDING order. As you can see, JavaScript's native comparison operators
			// can be used to compare dates. This was news to me.
			if (date1 > date2) return -1;
			if (date1 < date2) return 1;
			return 0;
		};
		var current_year = 0;
		var current_month = 0;
		var scroll_count = 2;
		var scrolled = 0;
		var scroll_time = 500;
		var calid = 0;
		var month=new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
		var config = {};
		if(options)
		{
			jQuery.extend(config, options);
		}
		/**------------------ BEGIN FUNCTION BODY ------------------**/
		return this.each(function(){
			if(options.scroll)
				scroll_count = parseInt(options.scroll);
			if(options.width)
				jQuery('.TimleLIne_TS_Cal_'+calid).css('width', options.width)
			if(options.scrollingTime)
				scroll_time = options.scrollingTime;
			calid = options.calid;
			month = options.month;
			var TimleLIne_TS_Cal_YAT = jQuery('#TimleLIne_TS_Cal_YAT_' + calid).val();
			var TimleLIne_TS_Cal_BAT = jQuery('#TimleLIne_TS_Cal_BAT_' + calid).val();
			var TimleLIne_TS_Cal_HDF = jQuery('#TimleLIne_TS_Cal_HDF_' + calid).val();
		/**------------------ INSERT  YEAR MONTH BAR------------------**/
			if(!jQuery('.TimleLIne_TS_Cal_'+calid).children('.TimleLIne_TS_Cal_wrap').children('.TimleLIne_TS_Cal_event.selected').length)
				jQuery('.TimleLIne_TS_Cal_'+calid).children('.TimleLIne_TS_Cal_wrap').children('.TimleLIne_TS_Cal_event:first-child').addClass('selected')
			//This store the selected year to 'current_year'
			current_year = (new Date()).getFullYear() 
			//This store the selected year to 'current_month'
			current_month = (new Date()).getMonth()
			current_day = (new Date()).getDate()
			//This will generate the month-year bar if it doesn't exist + put the current year and month
			if(!jQuery('.TimleLIne_TS_Cal_'+calid).children('.month-year-bar').length)
			{
				jQuery('.TimleLIne_TS_Cal_'+calid).prepend('<div class = "month-year-bar"></div>')
				if( TimleLIne_TS_Cal_HDF == 'format1' || TimleLIne_TS_Cal_HDF == 'format2')
				{
					jQuery('.TimleLIne_TS_Cal_'+calid).children('.month-year-bar').prepend('<div class = "year"><a class = "prev"><i class = "totalsoft totalsoft-'+TimleLIne_TS_Cal_YAT+'-left"></i></a><span>' + String(current_year) + '</span><a class = "next"><i class = "totalsoft totalsoft-'+TimleLIne_TS_Cal_YAT+'-right"></i></a></div>')
					jQuery('.TimleLIne_TS_Cal_'+calid).children('.month-year-bar').prepend('<div class = "month"><span>' + String(month[current_month]) + '</span></div>')
				}
				else if( TimleLIne_TS_Cal_HDF == 'format3' )
				{
					jQuery('.TimleLIne_TS_Cal_'+calid).children('.month-year-bar').prepend('<div class = "yearmonth"> <span class = "year"><a class = "prev"><i class = "totalsoft totalsoft-'+TimleLIne_TS_Cal_YAT+'-left"></i></a><span>' + String(current_year) + '</span><a class = "next"><i class = "totalsoft totalsoft-'+TimleLIne_TS_Cal_YAT+'-right"></i></a></span><span class = "month">' + String(month[current_month]) + '</span></div>')
				}
				else if( TimleLIne_TS_Cal_HDF == 'format4' )
				{
					jQuery('.TimleLIne_TS_Cal_'+calid).children('.month-year-bar').prepend('<div class = "yearmonth"><span class = "month">' + String(month[current_month]) + '</span><span class = "year"><a class = "prev"><i class = "totalsoft totalsoft-'+TimleLIne_TS_Cal_YAT+'-left"></i></a><span>' + String(current_year) + '</span><a class = "next"><i class = "totalsoft totalsoft-'+TimleLIne_TS_Cal_YAT+'-right"></i></a></span></div>')
				}
				jQuery('.TimleLIne_TS_Cal_'+calid).children(".month-year-bar").prepend('<div class = "TimleLIne_TS_Cal_LAH"></div>')
			}
		/**------------------ STORING DATES INTO ARRAY------------------**/
			var i = 0;
			// Store the dates into timelinedates[]
			jQuery('.TimleLIne_TS_Cal_'+calid).children('.TimleLIne_TS_Cal_wrap').children('.TimleLIne_TS_Cal_event').each(function(){
				timelinedates[i] = new Date(jQuery(this).attr('data-date'));
				i++;
			})
			//Sort the dates from small to large
			timelinedates.sort(date_sort_asc)
		/**------------------ INSERT DATES BAR------------------**/
			//This will insert the month year bar
			if(!jQuery('.TimleLIne_TS_Cal_'+calid).children(".dates-bar").length)
				jQuery('.TimleLIne_TS_Cal_'+calid).children(".month-year-bar").after('<div class = "dates-bar"><a class = "prev"><i class = "totalsoft totalsoft-'+TimleLIne_TS_Cal_BAT+'-left"></i></a><a class = "noevent" style="display:block;">No event found</a><a class = "next"><i class = "totalsoft totalsoft-'+TimleLIne_TS_Cal_BAT+'-right"></i></a></div>')
				jQuery('.TimleLIne_TS_Cal_'+calid).children(".dates-bar").prepend('<div class = "TimleLIne_TS_Cal_LAB"></div>')
			//This for loop will insert all the dates in the bar fetching from timelinedates[]
			for(i=0; i < timelinedates.length; i++)
			{
				dateString = String((timelinedates[i].getMonth() + 1) + "/" + timelinedates[i].getDate() + "/" + timelinedates[i].getFullYear())
				if(jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a[data-date = "'+ dateString +'"]').length)
					continue;
				jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a.prev').after('<a data-date = '+ dateString + '><span class = "date">' + String(timelinedates[i].getDate()) + '</span><span class = "month">' + String(month[timelinedates[i].getMonth()]) + '</span></a>')
			}
			//This will convert the event data-date attribute from mm/dd/yyyy into m/d/yyyy
			for(i = 0; i < jQuery('.TimleLIne_TS_Cal_'+calid).children('.TimleLIne_TS_Cal_wrap').children('.TimleLIne_TS_Cal_event').length; i++)
			{
				var a = new Date(jQuery('.TimleLIne_TS_Cal_'+calid).children('.TimleLIne_TS_Cal_wrap').children('.TimleLIne_TS_Cal_event:nth-child(' + String(i+1)+ ')').attr('data-date'))
				dateString = String((a.getMonth() + 1) + "/" + a.getDate() + "/" + a.getFullYear())
				jQuery('.TimleLIne_TS_Cal_'+calid).children('.TimleLIne_TS_Cal_wrap').children('.TimleLIne_TS_Cal_event:nth-child(' + String(i+1)+ ')').attr('data-date', dateString)
			}
			//This will hide the noevent bar
			jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a:not(.prev, .next, .noevent)').each(function(){
				if((new Date(jQuery(this).attr('data-date'))).getFullYear() != current_year)
					jQuery(this).hide();
				else
					jQuery(this).show();
				if(!jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a:not(.prev, .next, .noevent):visible').length){
					jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a.noevent').css('display', 'block');
				}else{
					jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a.noevent').css('display', 'none');
					jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a:not(.prev, .next, .noevent)').css('margin-left', '0');
					scrolled = 0;
					jQuery('.TimleLIne_TS_Cal_'+calid).children('.TimleLIne_TS_Cal_wrap').children('.TimleLIne_TS_Cal_event').removeClass('selected');
					var MonthArray = new Array();
					jQuery('.TimleLIne_TS_Cal_'+calid).children('.TimleLIne_TS_Cal_wrap').children('.TimleLIne_TS_Cal_event').each(function(){
						a = (new Date(jQuery(this).attr('data-date')));
						MonthArray.push(a);
						MonthArray.sort(function(ad, bd){return bd-ad});
					})
					var MonthCu = '';
					var current_year_real = (new Date()).getFullYear();
					var current_month_real = (new Date()).getMonth();
					var current_day_real = (new Date()).getDate();
					for(var i = 0; i < MonthArray.length; i++ )
					{
						if(MonthArray[i].getFullYear() == current_year_real && MonthArray[i].getMonth() == current_month_real && MonthArray[i].getDate() == current_day_real)
						{
							MonthCu = MonthArray[i];
						}
					}
					if(MonthCu == '')
					{
						for(var i = 0; i < MonthArray.length; i++ )
						{
							if(MonthArray[i].getFullYear() == current_year_real && MonthArray[i].getMonth() == current_month_real)
							{
								MonthCu = MonthArray[i];
							}
						}
					}
					if(MonthCu == '')
					{
						for(var i = 0; i < MonthArray.length; i++ )
						{
							if(MonthArray[i].getFullYear() == current_year_real)
							{
								MonthCu = MonthArray[i];
							}
						}
					}
					// alert(MonthCu);
					jQuery('.TimleLIne_TS_Cal_'+calid).children('.TimleLIne_TS_Cal_wrap').children('.TimleLIne_TS_Cal_event').each(function(){
						a = (new Date(jQuery(this).attr('data-date')))
						if(MonthCu && a.getFullYear() == MonthCu.getFullYear() && a.getMonth() == MonthCu.getMonth() && a.getDate() == MonthCu.getDate())
						{
							jQuery(this).addClass('selected')
							current_month = a.getMonth();
							jQuery('.TimleLIne_TS_Cal_'+calid).children('.month-year-bar').children('.month').children('span').text(month[current_month])
							return false;
						}

						// if(a.getFullYear() == current_year){
						// jQuery(this).addClass('selected')
						// current_month = a.getMonth();
						// jQuery('.TimleLIne_TS_Cal_'+calid).children('.month-year-bar').children('.month').children('span').text(month[current_month])
						// return false;
						// }
					})
				}
			})
			//Prevent from calling twice
			if(jQuery('.TimleLIne_TS_Cal_'+calid).hasClass('calledOnce'))
				return 0;
			jQuery('.TimleLIne_TS_Cal_'+calid).addClass('calledOnce')
			//Add 'selected' class the date
			jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a[data-date ="' + String(jQuery('.TimleLIne_TS_Cal_'+calid).children('.TimleLIne_TS_Cal_wrap').children('.TimleLIne_TS_Cal_event.selected').attr('data-date')) + '"]').addClass('selected')
			//Adding Class s_screen
			if(jQuery('.TimleLIne_TS_Cal_'+calid).width() < 500)
				jQuery('.TimleLIne_TS_Cal_'+calid).addClass('s_screen')
			jQuery(window).resize(function(){
				if(jQuery('.TimleLIne_TS_Cal_'+calid).width() < 500)
					jQuery('.TimleLIne_TS_Cal_'+calid).addClass('s_screen')
				else
					jQuery('.TimleLIne_TS_Cal_'+calid).removeClass('s_screen')
			})
		/**------------------ EVENTS HANDLING------------------**/
		/**------------------ EVENTS FOR CLICKING ON THE DATES ------------------**/
			jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a:not(.prev, .next, .noevent)').click(function(){
				a = String(jQuery(this).attr('data-date'));
				jQuery('.TimleLIne_TS_Cal_'+calid).children('.TimleLIne_TS_Cal_wrap').children('.TimleLIne_TS_Cal_event.selected').removeClass('selected');
				jQuery('.TimleLIne_TS_Cal_'+calid).children('.TimleLIne_TS_Cal_wrap').children('.TimleLIne_TS_Cal_event[data-date="' + a + '"]').addClass('selected');
				jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a:not(.prev, .next, .noevent)').removeClass('selected');
				current_month = new Date(a).getMonth();
				jQuery('.TimleLIne_TS_Cal_'+calid).children('.month-year-bar').children('.month').children('span').text(month[current_month])
				jQuery(this).addClass('selected')
			})
		/**------------------ EVENTS FOR CLICKING TO THE NEXT DATE EVENT ------------------**/
			jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a.next').click(function(){
				var actual_scroll = scroll_count;
				var c = jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a:not(.prev, .next, .noevent):visible()').length
				if(scrolled + scroll_count >= c)
					actual_scroll = (c - scrolled)-1;
				if(parseInt(jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a:not(.prev, .next, .noevent):visible():eq(0)').css('width'))*actual_scroll > jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').width())
					while(parseInt(jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a:not(.prev, .next, .noevent):visible():eq(0)').css('width'))*actual_scroll > jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').width() && actual_scroll > 1)
						actual_scroll -= 1;
				var a = (-1)*actual_scroll*parseInt(jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a:not(.prev, .next, .noevent):visible():eq(0)').css('width'));
				jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a:not(.prev, .next, .noevent):visible():eq(0)').animate({marginLeft: '+=' + String(a)+ 'px'}, scroll_time)
				scrolled += actual_scroll;
			})
		/**------------------ EVENTS FOR CLICKING TO THE PREVIOUS DATE EVENT ------------------**/
			jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a.prev').click(function(){
				var actual_scroll = scroll_count;
				var c = jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a:not(.prev, .next, .noevent):visible()').length
				if(scrolled <= scroll_count)
					actual_scroll = scrolled;
				if(parseInt(jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a:not(.prev, .next, .noevent):visible():eq(0)').css('width'))*actual_scroll > jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').width())
					while(parseInt(jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a:not(.prev, .next, .noevent):visible():eq(0)').css('width'))*actual_scroll > jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').width() && actual_scroll > 1)
						actual_scroll -= 1;
				var a = actual_scroll*parseInt(jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a:not(.prev, .next, .noevent):visible():eq(0)').css('width'));
				var a = parseInt(jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a:not(.prev, .next, .noevent):visible():eq(0)').css('width'));
				jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a:not(.prev, .next, .noevent):visible():eq(0)').animate({marginLeft: '+=' + String(a)+ 'px'}, scroll_time)
				scrolled -= actual_scroll;
			})
		/**------------------ EVENTS FOR CLICKING TO THE NEXT YEAR ------------------**/
			jQuery('.TimleLIne_TS_Cal_'+calid).children('.month-year-bar').children('.year').children('.next').click(function(){
				console.log(jQuery('.TimleLIne_TS_Cal_'+calid));
				current_year += 1;
				jQuery('.TimleLIne_TS_Cal_'+calid).children('.month-year-bar').children('.year').children('span').text(String(current_year))
				jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a:not(.prev, .next, .noevent)').each(function(){
					if((new Date(jQuery(this).attr('data-date'))).getFullYear() != current_year)
						jQuery(this).hide();
					else
						jQuery(this).show()
					if(!jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a:not(.prev, .next, .noevent):visible').length){
						jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a.noevent').css('display', 'block');
					}else{
						jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a.noevent').css('display', 'none');
						jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a:not(.prev, .next, .noevent)').css('margin-left', '0');
						scrolled = 0;
						jQuery('.TimleLIne_TS_Cal_'+calid).children('.TimleLIne_TS_Cal_wrap').children('.TimleLIne_TS_Cal_event').removeClass('selected');
						jQuery('.TimleLIne_TS_Cal_'+calid).children('.TimleLIne_TS_Cal_wrap').children('.TimleLIne_TS_Cal_event').each(function(){
							a = (new Date(jQuery(this).attr('data-date')))
							if(a.getFullYear() == current_year){
								jQuery(this).addClass('selected')
								current_month = a.getMonth();
								jQuery('.TimleLIne_TS_Cal_'+calid).children('.month-year-bar').children('.month').children('span').text(month[current_month])
								return false;
							}
						})
					}
				})
				jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a:not(.prev, .next, .noevent)').removeClass('selected');
				jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a[data-date ="' + String(jQuery('.TimleLIne_TS_Cal_'+calid).children('.TimleLIne_TS_Cal_wrap').children('.TimleLIne_TS_Cal_event.selected').attr('data-date')) + '"]').addClass('selected')
			})
			jQuery('.TimleLIne_TS_Cal_'+calid).children('.month-year-bar').children('.yearmonth').children('.year').children('.next').click(function(){
				current_year += 1;
				jQuery('.TimleLIne_TS_Cal_'+calid).children('.month-year-bar').children('.yearmonth').children('.year').children('span').text(String(current_year))
				jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a:not(.prev, .next, .noevent)').each(function(){
					if((new Date(jQuery(this).attr('data-date'))).getFullYear() != current_year)
						jQuery(this).hide();
					else
						jQuery(this).show()
					if(!jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a:not(.prev, .next, .noevent):visible').length)
					{
						jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a.noevent').css('display', 'block');
					}
					else
					{
						jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a.noevent').css('display', 'none');
						jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a:not(.prev, .next, .noevent)').css('margin-left', '0');
						scrolled = 0;
						jQuery('.TimleLIne_TS_Cal_'+calid).children('.TimleLIne_TS_Cal_wrap').children('.TimleLIne_TS_Cal_event').removeClass('selected');
						jQuery('.TimleLIne_TS_Cal_'+calid).children('.TimleLIne_TS_Cal_wrap').children('.TimleLIne_TS_Cal_event').each(function(){
							a = (new Date(jQuery(this).attr('data-date')))
							if(a.getFullYear() == current_year){
								jQuery(this).addClass('selected')
								current_month = a.getMonth();
								jQuery('.TimleLIne_TS_Cal_'+calid).children('.month-year-bar').children('.yearmonth').children('.month').children('span').text(month[current_month])
								return false;
							}
						})
					}
				})
				jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a:not(.prev, .next, .noevent)').removeClass('selected');
				jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a[data-date ="' + String(jQuery('.TimleLIne_TS_Cal_'+calid).children('.TimleLIne_TS_Cal_wrap').children('.TimleLIne_TS_Cal_event.selected').attr('data-date')) + '"]').addClass('selected')
			})
		/**------------------ EVENTS FOR CLICKING TO THE PREVIOUS YEAR ------------------**/
			jQuery('.TimleLIne_TS_Cal_'+calid).children('.month-year-bar').children('.year').children('.prev').click(function(){
				current_year -= 1;
				jQuery('.TimleLIne_TS_Cal_'+calid).children('.month-year-bar').children('.year').children('span').text(String(current_year))
				jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a:not(.prev, .next, .noevent)').each(function(){
					if((new Date(jQuery(this).attr('data-date'))).getFullYear() != current_year)
						jQuery(this).hide();
					else
						jQuery(this).show()
					if(!jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a:not(.prev, .next, .noevent):visible').length)
					{
						jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a.noevent').css('display', 'block');
					}
					else
					{
						jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a.noevent').css('display', 'none');
						jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a:not(.prev, .next, .noevent)').css('margin-left', '0');
						scrolled = 0;
						jQuery('.TimleLIne_TS_Cal_'+calid).children('.TimleLIne_TS_Cal_wrap').children('.TimleLIne_TS_Cal_event').removeClass('selected');
						jQuery('.TimleLIne_TS_Cal_'+calid).children('.TimleLIne_TS_Cal_wrap').children('.TimleLIne_TS_Cal_event').each(function(){
							a = (new Date(jQuery(this).attr('data-date')))
							if(a.getFullYear() == current_year){
								jQuery(this).addClass('selected')
								current_month = a.getMonth();
								jQuery('.TimleLIne_TS_Cal_'+calid).children('.month-year-bar').children('.month').children('span').text(month[current_month])
								return false;
							}
						})
					}
				})
				jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a:not(.prev, .next, .noevent)').removeClass('selected');
				jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a[data-date ="' + String(jQuery('.TimleLIne_TS_Cal_'+calid).children('.TimleLIne_TS_Cal_wrap').children('.TimleLIne_TS_Cal_event.selected').attr('data-date')) + '"]').addClass('selected')
			})
			jQuery('.TimleLIne_TS_Cal_'+calid).children('.month-year-bar').children('.yearmonth').children('.year').children('.prev').click(function(){
				current_year -= 1;
				jQuery('.TimleLIne_TS_Cal_'+calid).children('.month-year-bar').children('.yearmonth').children('.year').children('span').text(String(current_year))
				jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a:not(.prev, .next, .noevent)').each(function(){
					if((new Date(jQuery(this).attr('data-date'))).getFullYear() != current_year)
						jQuery(this).hide();
					else
						jQuery(this).show()
					if(!jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a:not(.prev, .next, .noevent):visible').length)
					{
						jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a.noevent').css('display', 'block');
					}
					else
					{
						jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a.noevent').css('display', 'none');
						jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a:not(.prev, .next, .noevent)').css('margin-left', '0');
						scrolled = 0;
						jQuery('.TimleLIne_TS_Cal_'+calid).children('.TimleLIne_TS_Cal_wrap').children('.TimleLIne_TS_Cal_event').removeClass('selected');
						jQuery('.TimleLIne_TS_Cal_'+calid).children('.TimleLIne_TS_Cal_wrap').children('.TimleLIne_TS_Cal_event').each(function(){
							a = (new Date(jQuery(this).attr('data-date')))
							if(a.getFullYear() == current_year){
								jQuery(this).addClass('selected')
								current_month = a.getMonth();
								jQuery('.TimleLIne_TS_Cal_'+calid).children('.month-year-bar').children('.yearmonth').children('.month').children('span').text(month[current_month])
								return false;
							}
						})
					}
				})
				jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a:not(.prev, .next, .noevent)').removeClass('selected');
				jQuery('.TimleLIne_TS_Cal_'+calid).children('.dates-bar').children('a[data-date ="' + String(jQuery('.TimleLIne_TS_Cal_'+calid).children('.TimleLIne_TS_Cal_wrap').children('.TimleLIne_TS_Cal_event.selected').attr('data-date')) + '"]').addClass('selected')
			})

			// jQuery(".TimleLIne_TS_Cal").css('display','none');
		var wsum = 0;
		// var month = new Array();
  // month[0] = "January";
  // month[1] = "February";
  // month[2] = "March";
  // month[3] = "April";
  // month[4] = "May";
  // month[5] = "June";
  // month[6] = "July";
  // month[7] = "August";
  // month[8] = "September";
  // month[9] = "October";
  // month[10] = "November";
  // month[11] = "December";
		// console.log(month);

  

				
				setTimeout(function(){
					jQuery('.dates-bar a:not(.noevent)').each(function(){
			wsum += jQuery(this).width();
		})
					// console.log(wsum)
		if (wsum > jQuery(".TimleLIne_TS_Cal_LAB").width()) {
			jQuery('.dates-bar a:not(.noevent) span').each(function(){
				if (jQuery(this).html() == month[new Date().getMonth()]) {
					// console.log(jQuery(this))
					// console.log(jQuery(this))
					// jQuery(this).click();
					var index = jQuery('.dates-bar a:not(.noevent)').index(jQuery(".dates-bar > .selected"));
					var scrolled = (index-1);
					jQuery('.dates-bar a:nth-child(3)').css('margin-left',-(jQuery(this).parent().width()*scrolled));
					// jQuery(".TimleLIne_TS_Cal").css('display','');
					jQuery(".noevent").css('display','none');
					return false;
				}
				else if(jQuery(this).html() == month[new Date().getMonth()+1]){
					// jQuery(this).click();
					var index = jQuery('.dates-bar a:not(.noevent)').index(jQuery(".dates-bar > .selected"));
					var scrolled = (index-1);
					
					jQuery('.dates-bar a:nth-child(3)').css('margin-left',-(jQuery(this).parent().width()*scrolled));
					// jQuery(".TimleLIne_TS_Cal").css('display','');
					jQuery(".noevent").css('display','none');
					return false;
				}
			})


			
		}
				},2500)

				// console.log(1)
				// console.log(month)
				// console.log(3)
		})
	}
})(jQuery)