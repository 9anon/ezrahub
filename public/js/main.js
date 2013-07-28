$(function() {

    Array.max = function(array){
        return Math.max.apply(Math, array);
    };

    $.fn.serializeObject = function() {
        var o = {};
        var a = this.serializeArray();
        $.each(a, function() {
            if (o[this.name] !== undefined) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };

    function poll_index() {
        //create an array of all thread ids on the board
        var thread_ids = [];
        $.each($('#no-sort-view div.thread-row'), function(key, value) {
            thread_ids.push($(this).data('thread-id'));
        });
        //find out what the most recent one is (highest)
        var latest_id = Array.max(thread_ids);
        //make a post request to the update method with the highest id
        $.post('/homepage/update', {'latest_id': latest_id}, function(data) {
            if (data.update == '1') {
                //there were new threads, prepend them to the list
                if ($('div.thread-row.sticky').length > 0) {
                    //there are stickied threads, append after the last one
                    $(data.threads_html).hide().insertAfter('div.thread-row.sticky:last').fadeIn(600);
                } else {
                    //no sticky threads, just append to the top
                    $(data.threads_html).hide().insertAfter('#no-sort-header').fadeIn(600);
                }
            }
            //poll again in 15 seconds
            setTimeout(poll_index, 15000);
        });
    }

    function poll_thread(){
        //create an array of all post ids on the board
        var post_ids = [];
        $.each($('div.thread-reply'), function(key, value) {
            post_ids.push($(this).data('post-id'));
        });
        //get rid of any posts that have been submitted by the new post form
        $.each(post_ids, function(key, value) {
            //check if this post was inserted with the form, not via the update
            var index = window.inserted_posts.indexOf(value);
            if (index != -1) {
                //it's in the array, this post was inserted with the form, get rid of it!
                post_ids.splice(index, 1);
            }
        });
        //find out what the most recent one is (highest)
        var latest_id;
        if (post_ids.length === 0) {
            //we don't want the array max to eval to -Infinity because there are no posts yet
            latest_id = $('#op-post').data('post-id');
        } else {
            latest_id = Array.max(post_ids);
        }
        //make a post request to update the page
        $.post('/thread/update/' + $('#thread').data('thread-id'), {'latest_id' : latest_id, 'inserted_posts' : JSON.stringify(window.inserted_posts)}, function(data) {
            if (data.update == '1') {
                //there were new threads, append them to the thread
                $(data.replies_html).hide().appendTo('#thread').fadeIn(300);
            }
            //poll again in 5 seconds
            setTimeout(poll_thread, 5000);
        });
    }

    //initialize the inserted posts array if we are on a thread page
    if ($('#thread').length > 0) {
        window.inserted_posts = [];
    } else if ($('#threads').length > 0) {
        //we are on the index page, initialize infinite scrolling
        window.scroll_iteration = 0;
    }

    //wait for 15 seconds until we initialize polling
    setTimeout(function () {
        //decide what we should poll, if anything
        if ($('#threads').length > 0 && $('#threads').data('poll') == '1') {
            //we are on the index page and we want to poll
            poll_index();
        } else if ($('#thread').length > 0) {
            //we are on a thread page
            poll_thread();
        } else {
            console.log('we are not polling here');
        }
    }, 10000);

    //show the home icon when hovering over ezra hub
    $('header h1.title').hoverIntent({
        over: function() {
            $('img.ezra').fadeOut(100);
            $('span.hover-container span.icon-home').fadeIn(300);
        },
        interval: 50,
        out: function() {
            $('span.hover-container span.icon-home').fadeOut(100);
            $('img.ezra').fadeIn(300);
        }
    });

    //move the footer to the left if there is no sidebar
    if ($('div#threads-navigation').length === 0) {
        $('footer').css('padding', '10px 18px').css('background', '#31353e url("/css/campuslarge.jpg") no-repeat -1px 0');
    }

    //show backtotop depending on where we are in the document
    $(window).scroll(function () {
        //take care of the sidebar
        if ($(this).scrollTop() > 15) {
            $('#back-to-top').fadeIn();
            $('div#threads-navigation').stop().animate({'padding-top': '35px'}, 100);
            $('div.selection-window').stop().animate({'top': '0px'}, 100);
        } else {
            $('#back-to-top').fadeOut();
            $('div#threads-navigation').stop().animate({'padding-top': $('header').css('height')}, 100);
            $('div.selection-window').stop().animate({'top': $('header').css('height')}, 100);
        }

        //take care of the thread index header
        if ($(this).scrollTop() > 35 && $('#threads').length > 0) {
            $('div#no-sort-header').addClass('fixed');
        } else {
            $('div#no-sort-header').removeClass('fixed');
        }

        //take care of the thread page header
        if ($(this).scrollTop() > 35 && $('#thread').length > 0) {
            $('div#thread-scroll-header').fadeIn(150);
        } else {
            $('div#thread-scroll-header').fadeOut(150);
        }

        //infinite scrolling for the homepage
        if ($('#threads').length > 0 && $(window).scrollTop() + $(window).height() > $(document).height() - 25) {
            $('#loading-indicator').fadeIn(15);
            $.post('/homepage/scroll', {'iteration': window.scroll_iteration}, function(data) {
                window.scroll_iteration = window.scroll_iteration + 1;
                $('#threads-container').append(data.threads_html);
                console.log('next iteration is: ' + window.scroll_iteration);
                $('#loading-indicator').fadeOut(15);
            });
        }
    });

    //back to top click
    $('#back-to-top a').click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 500);
        return false;
    });

    //size the thread title section so there is no overflow
    var old_width = parseInt($('div.main-section').css('width'), 10);
    var new_width = old_width - 0.05*old_width - 40;
    //apply the new width
    $('div.thread-title').css('width', new_width + 'px');

    //and when the window resizes
    $(window).resize(function() {
        //work out what the new width will be
        var old_width = parseInt($('div.main-section').css('width'), 10);
        var new_width = old_width - 0.05*old_width - 40;
        //apply the new width
        $('div.thread-column.thread-title, div.thread-column.thread-title h3').css('width', new_width + 'px');
    });

    //hovering over a normal thread
    $('#threads').on({
        mouseenter: function() {
            $(this).css('background', 'rgba(0, 0, 0, 0.06)').find('span.icon-indicator').css('color', '#999');
        },
        mouseleave: function() {
            if ($(this).is('div.thread-row:nth-child(2n)')) {
                $(this).css('background', '#f9f9f9').find('span.icon-indicator').css('color', 'transparent');
            } else {
                $(this).css('background', 'transparent').find('span.icon-indicator').css('color', 'transparent');
            }
        }
    }, 'div.thread-row:not(.sticky, .unread, .locked)');

    //hovering over a stickied thread
    $('#threads').on({
        mouseenter: function() {
            $(this).css('background', 'rgba(255, 153, 0, 0.35)');
        },
        mouseleave: function() {
            $(this).css('background', 'rgba(255, 153, 0, 0.25)');
        }
    }, 'div.thread-row.sticky');

    //hovering over an unread thread
    $('#threads').on({
        mouseenter: function() {
            $(this).css('background', 'rgba(0, 136, 204, 0.2)');
        },
        mouseleave: function() {
            $(this).css('background', 'rgba(0, 136, 204, 0.1)');
        }
    }, 'div.thread-row.unread:not(.sticky)');

    //hovering over a locked thread
    $('#threads').on({
        mouseenter: function() {
            $(this).css('background', 'rgba(255, 0, 0, 0.3)');
        },
        mouseleave: function() {
            $(this).css('background', 'transparent');
        }
    }, 'div.thread-row.locked');

    //new thread form show
    $(document).on('click', 'li.new-thread', function() {
        $('div#no-sort-view, div#-sort-view').hide();
        $('div#new-thread-container').show();
        $('li.user-link.mark-all-as-read').fadeOut(300);
        $(this).removeClass('new-thread').addClass('hide-new-thread').html('<span class="title icon-reply"></span>');
        return false;
    });

    //submitting new thread form
    $(document).on('submit', '#new-thread-form', function() {
        //submit the form
        $.post('/thread/new/', $('#new-thread-form').serializeObject(), function(data) {
            console.log(data);
            if (data.hasOwnProperty('new_thread_url')) {
                //it worked, redirect to the new thread
                window.location.replace('/thread/' + data.new_thread_url);
            } else {
                //get the error messages
                var error_messages = [];
                $.each(data.messages, function(key, value) {
                    error_messages.push(value);
                });
                //print them out in the error box
                $('form#new-thread-form p.errors').html('I\'m sorry, Dave, I\'m afraid I can\'t do that. There were some problems with your new thread. ' + error_messages.join(' ')).delay(1200).slideDown(400);
            }
        }, 'json');
        return false;
    });

    //hide new thread form and go back to browsing
    $(document).on('click', 'li.hide-new-thread', function() {
        $('#new-thread-container').hide();
        $('div#no-sort-view').fadeIn(300);
        $('li.user-link.mark-all-as-read').fadeIn(600);
        $(this).removeClass('hide-new-thread').addClass('new-thread').html('<a href="/thread/new"><span class="title icon-edit"></span><span class="selection">new thread</span></a>');
    });

    //submitting new reply form
    $('#new-reply-form').submit(function() {
        var thread_id = $('#thread').data('thread-id');
        //update the submit button to say we are submitting
        $('input#post-new-reply').addClass('submitted').val('Submitting...');
        //submit the form
        $.post('/post/new/' + thread_id, $('#new-reply-form').serializeObject(), function(data) {
            //reload the recaptcha
            if(typeof Recaptcha != 'undefined') {
               Recaptcha.reload();
            }
            if (data.success == 1) {
                //no errors, it worked, show success and play a sound (later)
                $('input#post-new-reply').removeClass('submitted').addClass('success').val('Success.');
                //empty the textarea
                $('#new-reply-form textarea').val('');
                //add the id of this post to the inserted-posts array globally
                window.inserted_posts.push(data.inserted_id);
                setTimeout(function() {
                    $('input#post-new-reply').removeClass('success').val('Post a new reply');
                    $('p.errors').hide();
                    //update post count by one
                    var post_count = parseInt($('li.browse-option.post-count span.number-highlight').html());
                    $('li.browse-option.post-count span.number-highlight').html(post_count + 1);
                    //add the new post to the thread
                    $(data.new_post).hide().appendTo('#thread').show();
                }, 600);
            } else {
                $('input#post-new-reply').removeClass('submitted').val('Post a new reply');
                //get the error messages
                var error_messages = [];
                $.each(data.messages.messages, function(key, value) {
                    error_messages.push(value);
                });
                //print them out in the error box
                $('form#new-reply-form p.errors').html('I\'m sorry, Dave, I\'m afraid I can\'t do that. There were some problems with your reply. ' + error_messages.join(' ')).slideDown(400);
            }

        }, 'json');
        return false;
    });

    //show users online modal window
    $(document).on('click', 'a.online-users', function() {
        //get the login view
        $.get('/users/online', function(data) {
            //close any modal windows that were open
            $.modal.close();
            //make a modal window with the html
            $.modal(data);
        });
        return false;
    });

    // show login modal form
    $(document).on('click', 'a.log-in, li.log-in', function() {
        //get the login view
        $.get('/login/', function(data) {
            //close any modal windows that were open
            $.modal.close();
            //make a modal window with the html
            $.modal(data);
        });
        return false;
    });

    //login switch option
    $(document).on('click', 'span.switch-option', function() {
        $(this).parents('div.log-in-option').hide();
        $(this).parents('div.log-in-option').siblings('div.log-in-option').fadeIn();
    });

    //submitting the login form
    $(document).on('submit', 'form#log-in-form', function() {
        //make a post request
        $.post('/login/', $('form#log-in-form').serializeObject(), function(data) {
            $('form#log-in-form p.errors').hide();
            if (data.hasOwnProperty('welcome_message')) {
                //it worked, we logged in! do some fancy stuff
                $('form#log-in-form input[type="text"], form#log-in-form input[type="password"]').val('');
                $('div.log-in-option.log-in').html(data.welcome_message);
                setTimeout(function() {
                    document.location.reload();
                }, 1500);
            } else {
                //there were errors, reset the form
                $('form#log-in-form input[type="text"], form#log-in-form input[type="password"]').val('');
                $('input#username').focus();
                //show the error
                $('form#log-in-form p.errors').html(data.errors).delay(1200).slideDown(400);
            }
        }, 'json');
        return false;
    });

    //submitting the signup form
    $(document).on('submit', 'form#sign-up-form', function() {
        //make a post request
        $.post('/signup/', $('form#sign-up-form').serializeObject(), function(data) {
            console.log(data);
            $('form#sign-up-form p.errors').hide();
            if (data.hasOwnProperty('welcome_message')) {
                //it worked, we created a new user
                $('div.log-in-option.sign-up').html(data.welcome_message);
                setTimeout(function() {
                    window.location.replace('/user/' + data.username);
                }, 1500);
            } else {
                //there were errors, clear the error fields
                $('form#sign-up-form input[type="text"], form#sign-up-form input[type="password"]').animate({backgroundColor: 'rgba(255, 255, 255, 0.15)'}, 300);
                //highlight the appropriate inputs
                $.each(Object.keys(data.messages), function(key, value) {
                    $('form#sign-up-form input#' + value).animate({backgroundColor: 'rgba(255, 0, 0, 0.3)'}, 1000);
                });
                //get the error messages
                var error_messages = [];
                $.each(data.messages, function(key, value) {
                    error_messages.push(value);
                });
                //print them out in the error box
                $('form#sign-up-form p.errors').html('I\'m sorry, Dave, I\'m afraid I can\'t do that. ' + error_messages.join(' ')).delay(1200).slideDown(400);
            }
        }, 'json');
        return false;
    });

    //mark all as read
    $('li.user-link.mark-all-as-read').click(function() {
        $.get('thread/read/all', function(data) {
            //reset the selection window
            $('li.browse-option').removeClass('active');
            $('div.selection-window').fadeOut(150);
            //hide the unread icons
            $('div.thread-row.unread').removeClass('unread');
        });
        return false;
    });

    //rep or neg a user modal dialog
    $(document).on('click', 'span.reputation', function() {
        //find out which user we are repping or negging
        var target = $(this).data('user-id');
        //get the rep view for the appropriate user
        $.get('/rep/show/' + target, function(data) {
            //make a modal window with the html
            $.modal(data);
        });
        return false;
    });

    //selecting either rep or neg
    $(document).on('click', 'div.rep-actions > div', function() {
        $('div.rep-actions > div').removeClass('selected');
        $(this).addClass('selected');
    });

    //submitting the rep or neg form
    $(document).on('submit', 'form#submit-rep-form', function() {
        //find out which user we are repping or negging
        var target = $(this).data('user-id');
        //which out whether we are repping or negging
        var action = $('div.rep-actions > div.selected').data('action');
        //reset the errors
        $('form#submit-rep-form p.errors').hide();
        //make sure we picked an action
        if (!action) {
            //we didn't pick an action, whoops
            $('form#submit-rep-form p.errors').html('You must pick an action, rep or neg.').delay(1200).slideDown(400);
            return false;
        }
        //show we are submitting
        $('input.submit-rep').addClass('submitted').val('Submitting...');
        //send the post request
        $.post('/rep/' + action + '/' + target, $('form#submit-rep-form').serializeObject(), function(data) {
            console.log(data);
            if (data.success == '0') {
                //get the error messages
                var error_messages = [];
                $.each(data.messages, function(key, value) {
                    error_messages.push(value);
                });
                //print them out in the error box
                $('form#submit-rep-form p.errors').html('I\'m sorry, Dave, I\'m afraid I can\'t do that. ' + error_messages.join(' ')).delay(1200).slideDown(400);
            } else {
                //no errors, it worked, show success and play a sound (later)
                $('input.submit-rep').removeClass('submitted').addClass('success').val('Success.');
                //empty the textarea and clear the action
                $('form#submit-rep-form input[type="text"]').val('');
                $('div.rep-actions > div').removeClass('selected');
                setTimeout(function() {
                    $('input.submit-rep').val('Submit').removeClass('success');
                    $.modal.close();
                }, 600);
            }
        }, 'json');
        return false;
    });

    //user profile navigation
    $('#user-profile-navigation > nav > ul > li:not(.unhoverable)').click(function() {
        var target = $(this).data('option');
        //hide them all and remove active class
        $('div.user-profile-item').hide().addClass('hidden');
        $('#user-profile-navigation > nav > ul > li').removeClass('active');
        //show the correct one and add the active class
        $('div.user-profile-item.' + target).show().removeClass('hidden');
        $('#user-profile-navigation > nav > ul > li.' + target).addClass('active');
        return false;
    });

    //reading a message
    $('div.message-item').click(function() {
        var message_id = $(this).data('message-id');
        $.get('/message/read/' + message_id, function(data) {
            console.log(data);
            $('div#message-' + message_id).removeClass('unread');
            $('div#messages-container').hide();
            $('div#message-reading-pane').html(data);
        });
        return false;

    })

    //change avatar
    $('span.edit-avatar').click(function() {
        $.get('/user/avatar/form', function(data) {
            //make a modal window with the html
            $.modal(data);
        });
        return false;
    });

    //submit avatar change form
    $(document).on('submit', 'form#change-avatar-form', function() {
        $('input#upload-new-avatar').addClass('submitted').val('Submitting...');
        //capture the image with formdata
        //does NOT work in IE9 :( fuck that
        var form_data = new FormData($('form#change-avatar-form')[0]);

        //define progress handling function to show percentage
        function progress_function(e){
            if(e.lengthComputable){
                $("div#progress").text(e.loaded + " / " + e.total + " uploaded");
            }
        }

        //make the ajax request (don't use shorthand because file upload and formdata)
        $.ajax({
            url: '/user/avatar/edit/',
            type: 'POST',
            xhr: function() {
                // custom xhr
                my_xhr = $.ajaxSettings.xhr();
                if(my_xhr.upload){ // check if upload property exists
                    //call progress handling function
                    my_xhr.upload.addEventListener('progress', progress_function, false);
                }
                return my_xhr;
            },
            success: function(data) {
                console.log(data);
                if (data.success == '1') {
                    $('input#upload-new-avatar').removeClass('submitted').addClass('success').val('Success!');
                    //reload the page
                    setTimeout(function() {
                        document.location.reload();
                    }, 1000);
                } else {
                    //it failed :(, do some animation stuff
                    $('input#upload-new-avatar').removeClass('submitted').val('Upload');
                    //get the error messages
                    var error_messages = [];
                    $.each(data.messages, function(key, value) {
                        error_messages.push(value);
                    });
                    //print them out in the error box
                    $('form#change-avatar-form p.errors').html('I\'m sorry, Dave, I\'m afraid I can\'t do that. ' + error_messages.join(' ')).delay(1200).slideDown(400);
                }
            },
            data: form_data,
            //tell jquery not to process data or worry about content-type
            cache: false,
            contentType: false,
            processData: false
        });

        return false;
    });

    //change bio
    $('span.edit-bio').click(function() {
        $.get('/user/bio/form', {previous: $('span.user-bio').text()}, function(data) {
            $('span.edit-bio, span.user-bio').hide();
            $('span.user-bio').parent('p').append(data);
        });
        return false;
    });

    //submit change bio form
    $(document).on('submit', 'form#change-bio-form', function() {
        $('input#edit-bio-submit').addClass('submitted').val('Submitting...');
         //make a post request
        $.post('/user/bio/edit', $('form#change-bio-form').serializeObject(), function(data) {
            if (data.success == '1') {
                //change the form state
                $('input#edit-bio-submit').removeClass('submitted').addClass('success').val('Success!');
                $("form#change-bio-form textarea").attr("disabled","disabled");
                setTimeout(function() {
                    //remove the form
                    $('form#change-bio-form').remove();
                    //replace the bio
                    $('span.user-bio').html(data.new_bio).show();
                    $('span.edit-bio').show();
                }, 1000);
            } else {
                //it failed :(, do some animation stuff
                $('input#edit-bio-submit').removeClass('submitted').val('Submit bio');
                //get the error messages
                var error_messages = [];
                $.each(data.messages, function(key, value) {
                    error_messages.push(value);
                });
                //print them out in the error box
                $('form#change-bio-form p.errors').html('I\'m sorry, Dave, I\'m afraid I can\'t do that. ' + error_messages.join(' ')).delay(1200).slideDown(400);
            }

        });
        return false;
    });

    //submit change password form
    $(document).on('submit', 'form#edit-password-form', function() {
        $('input#edit-bio-submit').addClass('submitted').val('Submitting...');
         //make a post request
        $.post('/user/password/edit', $('form#edit-password-form').serializeObject(), function(data) {
            if (data.success == '1') {
                //change the form state
                $('input#edit-password-submit').removeClass('submitted').addClass('success').val('Success!');
                $('form#edit-password-form p.success').html('Password successfully changed.').slideDown(400);
                setTimeout(function() {
                    //reset the state
                    $('input#edit-password-submit').removeClass('success').val('Change password');
                    $('form#edit-password-form p.success').fadeOut();
                }, 1500);
            } else {
                //it failed :(, do some animation stuff
                $('input#edit-password-submit').removeClass('submitted').val('Change password');
                //empty the form inputs
                $('form#edit-password-form input[type="text"]').val('');
                //get the error messages
                var error_messages = [];
                $.each(data.messages, function(key, value) {
                    error_messages.push(value);
                });
                //print them out in the error box
                $('form#edit-password-form p.errors').html('I\'m sorry, Dave, I\'m afraid I can\'t do that. ' + error_messages.join(' ')).delay(1200).slideDown(400);
            }

        });
        return false;
    });

    //submit change email form
    $(document).on('submit', 'form#edit-email-form', function() {
        $('input#edit-bio-submit').addClass('submitted').val('Submitting...');
         //make a post request
        $.post('/user/email/edit', $('form#edit-email-form').serializeObject(), function(data) {
            if (data.success == '1') {
                //change the form state
                $('input#edit-email-submit').removeClass('submitted').addClass('success').val('Success!');
                $('form#edit-email-form p.success').html('Email successfully changed.').slideDown(400);
                setTimeout(function() {
                    //reset the state
                    document.location.reload();
                }, 1500);
            } else {
                //it failed :(, do some animation stuff
                $('input#edit-bio-submit').removeClass('submitted').val('Change email');
                //get the error messages
                var error_messages = [];
                $.each(data.messages, function(key, value) {
                    error_messages.push(value);
                });
                //print them out in the error box
                $('form#edit-email-form p.errors').html('I\'m sorry, Dave, I\'m afraid I can\'t do that. ' + error_messages.join(' ')).delay(1200).slideDown(400);
            }

        });
        return false;
    });

    //submit delete avatar form
    $('form#delete-avatar-form').submit(function() {
        $.post('/user/avatar/delete', '', function(data) {
            //print the success message
            $('form#delete-avatar-form p.success').html('Avatar successfully deleted.').delay(1200).slideDown(400);
            setTimeout(function() {
                //reload the page
                document.location.reload();
            }, 1500);
        });
        return false;
    });

    //settings options expand
    $('div.settings-option > h4').click(function() {
        $(this).siblings('form').fadeToggle();
    });

    //scroll to reply form
    $('li.user-link.reply').click(function() {
        $('html, body').animate({
            //scroll to it
            scrollTop: $("#new-reply").offset().top
        }, 1000);
        //focus on the textarea
        $('#new-reply textarea').focus();
        return false;
    });

    //hovering over a post to see the post options
    $('#thread').on({
        mouseenter: function() {
            $(this).find('span.post-controls').show();
        },
        mouseleave: function() {
            $(this).find('span.post-controls').hide();
        }
    }, 'div.thread-reply, div#op-post');

    //quoting a post (also works to quote a thread)
    $(document).on('click', 'span.quote', function() {
        //find out what post we want
        var post_id = $(this).closest('div.thread-reply').data('post-id');
        if (!post_id) {
            //this is a thread instead
            post_id = $(this).closest('div#op-post').data('post-id');
        }
        //send a get request
        $.get('/post/quote/' + post_id, function(data) {
            //put it in the textarea
            $('textarea.enhanced').val($('textarea.enhanced').val() + data.content);
            //scroll to the textarea
            $('html, body').animate({
                scrollTop: $("#new-reply").offset().top
            }, 1000);
        });
        return false;
    });

    //editing a post
    $(document).on('click', 'span.edit', function() {
        //find out what post we want
        var post_id;
        var thread;
        if ($(this).hasClass('thread')) {
            //we're editing a thread
            post_id = $(this).closest('div#op-post').data('post-id');
            thread = true;
        } else {
            //we're editing a post
            post_id = $(this).closest('div.thread-reply').data('post-id');
            thread = false;
        }
        //send a get request
        $.get('/post/edit/' + post_id, function(data) {
            if (thread === true) {
                $('div#op-post div.post-body').replaceWith(data);
            } else {
                $('div#post-' + post_id + ' div.post-body').replaceWith(data);
            }
        });
        return false;
    });

    //submitting edit post form
    $(document).on('submit', '#edit-post-form', function() {
        var post_id = $(this).data('post-id');
        //update the submit button to say we are submitting
        $('input#submit-edited-post').addClass('submitted').val('Submitting...');
        //submit the form
        $.post('/post/edit/' + post_id, $('#edit-post-form').serializeObject(), function(data) {
            if (data.success == 1) {
                //no errors, it worked, show success and play a sound (later)
                $('input#submit-edited-post').removeClass('submitted').addClass('success').val('Success.');
                setTimeout(function() {
                    $('div#edit-post').replaceWith('<div class="post-body">' + data.new_post_body + '</div>');
                }, 800);
            } else {
                //do some fancy animation stuff
                $('input#post-new-reply').val('Post a new reply').removeClass('submitted');
                //get the error messages
                var error_messages = [];
                $.each(data.messages.messages, function(key, value) {
                    error_messages.push(value);
                });
                //print them out in the error box
                $('form#new-reply-form p.errors').html('I\'m sorry, Dave, I\'m afraid I can\'t do that. There were some problems with your reply. ' + error_messages.join(' ')).delay(1200).slideDown(400);
            }

        }, 'json');
        return false;

    });

    //deleting a post
    $(document).on('click', 'span.delete-post', function() {
        //find out what post we want
        var post_id = $(this).closest('div.thread-reply').data('post-id');
        //show the loading indicator
        $('#loading-indicator').fadeIn(150);
        //send a get request
        $.post('/post/delete/' + post_id, function(data) {
            console.log(data);
            if (data.success == 1) {
                $('#loading-indicator').fadeOut();
                setTimeout(function() {
                    //remove that post from the page
                    $('#post-' + post_id).hide(600, function(){
                        $(this).remove();
                    });
                }, 850);
            }
        });
        return false;
    });

    //deleting a thread
    $(document).on('click', 'span.delete-thread', function() {
        //make the user confirm
        var confirmation = confirm("Are you sure you want to delete this thread? You won't be able to get it back.");
        if (confirmation === true) {
            //find out what thread we want
            var thread_id = $(this).closest('div#thread').data('thread-id');
            $('#loading-indicator').fadeIn(150);
            //send a get request
            $.post('/thread/delete/' + thread_id, function(data) {
                console.log(data);
                if (data.success == '1') {
                    //it worked, redirect to the homepage
                    window.location.replace("/");
                } else {
                    alert('An error occured while deleting this thread. Please try again');
                }
            });
        } else {
            console.log('second thoughts there, eh?');
        }
        return false;
    });

    //stickying a thread
    $(document).on('click', 'span.sticky-thread', function() {
        //make the user confirm
        var confirmation = confirm("Are you sure you want to sticky/unsticky this thread?");
        if (confirmation === true) {
            //find out what thread we want
            var thread_id = $(this).closest('div#thread').data('thread-id');
            $('#loading-indicator').fadeIn(150);
            //send a get request
            $.post('/thread/sticky/' + thread_id, function(data) {
                console.log(data);
                if (data.success == '1') {
                    //it worked, redirect to the homepage
                    document.location.reload();
                } else {
                    alert('An error occured while stickying this thread. Please try again');
                }
                $('#loading-indicator').fadeOut(150);
            });
        } else {
            console.log('second thoughts there, eh?');
        }
        return false;
    });

    //locking a thread
    $(document).on('click', 'span.lock-thread', function() {
        //make the user confirm
        var confirmation = confirm("Are you sure you want to lock/unlock this thread?");
        if (confirmation === true) {
            //find out what thread we want
            var thread_id = $(this).closest('div#thread').data('thread-id');
            $('#loading-indicator').fadeIn(150);
            //send a get request
            $.post('/thread/lock/' + thread_id, function(data) {
                console.log(data);
                if (data.success == '1') {
                    //it worked, redirect to the homepage
                    document.location.reload();
                } else {
                    alert('An error occured while locking this thread. Please try again');
                }
                $('#loading-indicator').fadeOut(150);
            });
        } else {
            console.log('second thoughts there, eh?');
        }
        return false;
    });

    //bumplocking a thread
    $(document).on('click', 'span.bump-lock-thread', function() {
        //make the user confirm
        var confirmation = confirm("Are you sure you want to bumplock/unbumplock this thread?");
        if (confirmation === true) {
            //find out what thread we want
            var thread_id = $(this).closest('div#thread').data('thread-id');
            $('#loading-indicator').fadeIn(150);
            //send a get request
            $.post('/thread/bumplock/' + thread_id, function(data) {
                console.log(data);
                if (data.success == '1') {
                    //it worked, redirect to the homepage
                    document.location.reload();
                } else {
                    alert('An error occured while bumplocking this thread. Please try again');
                }
                $('#loading-indicator').fadeOut(150);
            });
        } else {
            console.log('second thoughts there, eh?');
        }
        return false;
    });

    //sending a message
    $(document).on('submit', '#new-message-form', function() {
        //work out who we're sending this to
        var user_id = $('#user-profile').data('id');
        //update the submit button to say we are submitting
        $('input#post-new-message').addClass('submitted').val('Submitting...');
        //submit the form
        $.post('/message/send/' + user_id, $('#new-message-form').serializeObject(), function(data) {
            if (data.success == '1') {
                //no errors, it worked, show success and play a sound (later)
                $('input#post-new-message').removeClass('submitted').addClass('success').val('Success.');
                $('form#new-message-form p.success').html('Message sent.').slideDown(400);
                //empty the textarea
                $('#new-message-form textarea').val('');
                setTimeout(function() {
                    $('input#post-new-message').val('Send another message').removeClass('success');
                    $('form#new-message-form p.success').fadeOut(150);
                }, 1500);
            } else {
                //do some fancy animation stuff
                $('input#post-new-message').val('Send your message').removeClass('submitted');
                //get the error messages
                var error_messages = [];
                $.each(data.messages, function(key, value) {
                    error_messages.push(value);
                });
                //print them out in the error box
                $('form#new-message-form p.errors').html('I\'m sorry, Dave, I\'m afraid I can\'t do that. ' + error_messages.join(' ')).delay(1200).slideDown(400);
            }

        }, 'json');
        return false;
    });
});
