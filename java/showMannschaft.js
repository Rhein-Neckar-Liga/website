$(document).ready(function(){
                $(".mannschaft").each(function(){
                    $(this).qtip(
                    {
                        content: {
                            url: "includes/scripts/showMannschaft.php",
                            data: { mannschaft: $(this).text(),
                                liga: document.$_GET['liga']},
                            method: 'get'
                        },
                        style: {
                            //border: { width: 2, radius: 5 },
                            width: 300
                        },
						//position: { type: 'fixed' },
                        show: { effect: { type: 'fade', length: 350 },when: 'click',solo: true },
                        //show: {when: 'click',solo: true},
						hide: { when: { event: 'unfocus' , fixed: false} }
						//hide: { when: { event:'unfocus', fixed: false },
                        //hide:'unfocus'
                    });
                });
            });