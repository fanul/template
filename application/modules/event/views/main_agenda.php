

<div id="da-content-area">

    <div class="grid_4">
        <div class="da-panel">

                                       <!-- <div class="da-panel-title"><?php if (isset($title)) echo $title; ?></div> -->
            <div class="da-panel-widget">
                <div class="da-panel-content">
                    <div id="da-ex-calendar-gcal" class="fc">

                    </div>
                    <script type="text/javascript" >
                        $(document).ready(function(){
                                                                
                            $("#da-ex-calendar-gcal").fullCalendar({
                                                    
                                firstDay:'1',
                                weekMode:'liquid',
                                aspectRatio: '1.5',
                                theme:true,
                                selectable:true,
                                timeFormat:'H:mm',
                                axisFormat:'H:mm',
                                columnFormat:{
                                    month: 'ddd',    // Mon
                                    week: 'ddd dS', // Mon 9/7
                                    day: 'dddd dS MMMM'  // Monday 9/7
                                },
                                titleFormat:{
                                    month: 'MMMM yyyy',                             // September 2009
                                    week: "MMM d[ yyyy]{ 'to'[ MMM] d, yyyy}", // Sep 7 - 13 2009
                                    day: 'ddd, MMMM d, yyyy'                  // Tuesday, Sep 8, 2009
                                },
                                allDaySlot: false,
                                header:{
                                    left:   'prev title next, today',
                                    center: '',
                                    right:  'agendaWeek,agendaDay,month'
                                },
                                dayClick: function(date, allDay, jsEvent, view) {
                                    if  (view.name == 'month') 
                                    {
                                        $('#da-ex-calendar-gcal').fullCalendar('changeView', 'agendaDay');
                                        $('#da-ex-calendar-gcal').fullCalendar( 'gotoDate', date );
                                    }
                                },
                                events: {
                                    url: '<?php echo site_url('event/agenda/generate_calendar_json') ?>',
                                    type: 'POST',
                                    error: function() {
                                        alert('there was an error while fetching events!');
                                    }
                                }

                            });
                                                        
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>

    <div class="clear"></div>

