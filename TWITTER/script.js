$(document).ready(function() {
    setInterval(ajaxCall_refresh, 1000);
    $(this).on('keyup', ajaxCall_search);

    $('#modifierProfil').on('click', function(){
        $('#formModifProfil').css('display', 'block');
        if($('#modifierProfil').html() == 'Retour'){
            $('#modifierProfil').html('Modifier le profil');
            $('#formModifProfil').css('display', 'none');
        }else{
            $('#modifierProfil').html('Retour');
        }
    });

    function ajaxCall_search(event){
        if(event.which == 13 && $('#recherche').val() !== ""){
            console.log($('#recherche').val());
            $('#recherche').val("");
        }
            
//tentative recherche ajax des utilisateurs
        // $('#submit_search').on('click', function(){
        //     $('#timeline').css('display', 'none');
        //     $('#result_search').html('');
        //     var user = $(this).val();
        //     $.ajax({
        //         type: 'POST',
        //         url: 'model.php',
        //         data: 'user=' + encodeURIComponent(user),
        //         success: function(data){
        //             if(data != ""){
        //                 $('#result_search').append(data);
        //             } 
        //             // else{
        //             //     document.getElementById('result_search').innerHTML = "<div id='no_result' style='font-size: 20px; text-align: center; margin-top: 10px'>Aucun utilisateur</div>"
        //             //   }

        //         }
        //     })
        // })
    }

    function ajaxCall_refresh(){
        var requete = $.ajax({
            type: 'POST',
            url: 'controler.php',
            dataType: 'json',
            data: 'refresh',
        });

        requete.done(function(reponse){
            $('#timeline').children().remove();
            //console.log(reponse);
            if(reponse[0]['page'] == 'accueil' || reponse[0]['page'] == 'explore'){
                let j = 5;
                console.log(reponse);
                while(j < reponse.length){
                    reponse[j]['id_user'].shift();
                    let idU = reponse[j]['id_user'][0];
                    let idUserSession = reponse[0]['id_user'];
                    let idT = reponse[j]['id_tweet'];
                    let nbLike = reponse[2][idT]['nbFav'];
                    let name = reponse[j]['first_name']+" "+reponse[j]['last_name'];
                    let blocTweet;
                    if(idUserSession == idU){
                        blocTweet = "<div class='tweet' id='"+reponse[j]['id_tweet']+"'><div class='tweetHead'><img class='profilPic' src='https://www.bit.ly/"+reponse[j]['picture']+"'/><div class='tweetName'><h5 style='font-size: 22px'><a href='profil.php?page=profil&id_user="+idUserSession+"'>"+name+"</a></h5><h6 id='username'>"+reponse[j]['username']+ '  <b>·</b>  ' +reponse[j]['created_date'].substr(0,10)+"</h6></div></div><p class='tweetContent' id='content"+reponse[j]['id_tweet']+"'>"+reponse[j]['content']+"</p></div>";
                    }else{
                        blocTweet = "<div class='tweet' id='"+reponse[j]['id_tweet']+"'><div class='tweetHead'><img class='profilPic' src='https://www.bit.ly/"+reponse[j]['picture']+"'/><div class='tweetName'><h5 style='font-size: 22px'><a href='profil.php?page=profil&id_user="+idU+"'>"+name+"</a></h5><h6 id='username'>"+reponse[j]['username']+ '  <b>·</b>  ' +reponse[j]['created_date'].substr(0,10)+"</h6></div><button class='suivre' id='suivre"+j+"'>follow</button></div><p class='tweetContent' id='content"+reponse[j]['id_tweet']+"'>"+reponse[j]['content']+"</p></div>";
                    }
                    let idTweet = "#"+reponse[j]['id_tweet'];
                    if(reponse[j]['media_link'] !== null){
                        var blocImg = "<img src='"+reponse[j]['media_link']+"'/>";
                    }
                    $('#timeline').append(blocTweet);
                    $(idTweet).append(blocImg);
                    $(idTweet).append("<div class='tweetFoot'><p class='reply'>Répondre</p><p class='retweeter' id='retweet"+reponse[j]['id_tweet']+"'>Retweeter</p><div class='like' id='like"+reponse[j]['id_tweet']+"'></div><p class='nbLike' id='nbLike"+reponse[j]['id_tweet']+"'>"+nbLike+"</p><p class='partager'>Partager</p></div>");
                    let likeTweet = "#like"+reponse[j]['id_tweet'];
                    if(reponse[4][idT]){
                        $(likeTweet).css({"background":"no-repeat url('assets_twitter/heart_hover20.png') 3px 3px", "background-color":"#ffacac", "padding":"3px", "border-radius":"50%"});
                    }
                    let suivre = "#suivre"+j;
                    if(reponse[3][idU]){
                        $(suivre).html("unfollow");
                    }
                    console.log(reponse[j]['id_user'][0]);
                    let strJSON = "\"id_user\":\""+reponse[j]['id_user'][0]+"\"";
                    let idUserTweet = JSON.parse("{"+strJSON+"}");
                    $(suivre).on('click', idUserTweet, ajaxCall_follow);

                    let retweet = '#retweet'+reponse[j]['id_tweet'];
                    strJSON = "\"content\" : \""+reponse[j]['content']+"\", \"id_tweet\":\""+reponse[j]['id_tweet']+"\", \"id_user_tweet\":\""+reponse[j]['id_user'][0]+"\"";
                    idTweet = JSON.parse("{"+strJSON+"}");
                    //console.log(retweet);
                    $(retweet).on('click', idTweet, ajaxCall_retweet);
                    $(likeTweet).off('click');
                    $(likeTweet).on('click', ajaxCall_like);
                    j++;
                }
            }else if(reponse[0]['page'] == 'profil'){
                j = 0; i = 0;
                var idUserFollow = [];
                $('#following').children().remove();
                while(j < reponse[2].length){
                    for(k = 0; k < reponse[2][j].length; k++){
                        idUserFollow[k] = reponse[2][j]['id_user_follow'] ;
                    }
                    if(reponse[2][j]['id_user_follow'] !== reponse[0]['id_user_profil']){
                        idUserFollow[i] = reponse[2][j]['id_user_follow'];
                        let name = reponse[2][j]['first_name']+" "+reponse[2][j]['last_name'];
                        if(reponse[2][j]['id_user_follow'] == reponse[0]['id_user']){
                            blocProfil = "<div class='blocProfil'><img class='profilPic' src='https://www.bit.ly/"+reponse[2][j]['picture']+"'/><div class='tweetName'><a href='profil.php?id_user="+reponse[2][j]['id_user_follow']+"&page=profil'><h5 style='font-size: 22px'>"+name+"</h5></a><h6 id='username'>"+reponse[2][j]['username']+"</h6></div></div><hr>";
                        }else{
                            blocProfil = "<div class='blocProfil'><img class='profilPic' src='https://www.bit.ly/"+reponse[2][j]['picture']+"'/><div class='tweetName'><a href='profil.php?id_user="+reponse[2][j]['id_user_follow']+"&page=profil'><h5 style='font-size: 22px'>"+name+"</h5></a><h6 id='username'>"+reponse[2][j]['username']+"</h6></div><button class='suivre' id='suivre"+reponse[0]['id_user']+"'>unfollow</button></div><hr>";
                        }
                        //console.log(reponse[0]['id_user'])
                        $('#following').append(blocProfil)
                        let strJSON = "\"id_user\":\""+reponse[2][j]['id_user_follow']+"\"";
                        let idUserTweet = JSON.parse("{"+strJSON+"}");
                        var suivre = '#suivre'+reponse[0]['id_user'];
                        $(suivre).off();
                        $(suivre).on('click', idUserTweet, ajaxCall_follow);
                        i++;
                    }
                    j++; 
                }
                j = 0;
                $('#follower').children().remove();
                while(j < reponse[1].length){
                    //console.log(idUserFollow);
                    if(reponse[1][j]['id_user'] !== reponse[0]['id_user_profil']){
                        let name = reponse[1][j]['first_name']+" "+reponse[1][j]['last_name'];
                        if(reponse[1][j]['id_user'] == reponse[0]['id_user']){
                            blocProfil =  blocProfil = "<div class='blocProfil'><img class='profilPic' src='https://www.bit.ly/"+reponse[1][j]['picture']+"'/><div class='tweetName'><a href='profil.php?id_user="+reponse[1][j]['id_user']+"&page=profil'><h5 style='font-size: 22px'>"+name+"</h5></a><h6 id='username'>"+reponse[1][j]['username']+"</h6></div></div><hr>";
                        }else{
                            blocProfil = "<div class='blocProfil'><img class='profilPic' src='https://www.bit.ly/"+reponse[1][j]['picture']+"'/><div class='tweetName'><a href='profil.php?id_user="+reponse[1][j]['id_user']+"&page=profil'><h5 style='font-size: 22px'>"+name+"</h5></a><h6 id='username'>"+reponse[1][j]['username']+"</h6></div><button class='suivre' id='suivre"+reponse[0]['id_user']+"'>follow</button></div><hr>";
                        }
                        $('#follower').append(blocProfil)
                        suivre = '#suivre'+reponse[0]['id_user'];
                        for(let k = 0; k < idUserFollow.length; k++){
                            if(reponse[1][j]['id_user'] == idUserFollow[k]){
                                $(suivre).html('unfollow');
                            }
                        }
                        let strJSON = "\"id_user\":\""+reponse[1][j]['id_user']+"\"";
                        let idUserTweet = JSON.parse("{"+strJSON+"}");
                        $(suivre).on('click', idUserTweet, ajaxCall_follow);
                    }
                    j++; i++;
                }
                if(reponse[0]['id_user'] == reponse[0]['id_user_profil']){
                    reponse[0]['nbFollowing']--;
                    reponse[0]['nbFollower']--;
                    follow = "";
                }else if(reponse[4]){
                    follow = "<button class='suivre'>Unfollow</button>";
                }else{
                    follow = "<button class='suivre'>Follow</button>";
                }
                nom = reponse[3]['first_name']+" "+reponse[3]['last_name'];
                img = "<img class='profilPic_profil' src='https://www.bit.ly/"+reponse[3]['picture']+"'/>";
                str = "Suivis : "+reponse[0]['nbFollowing']+"  |  Followers : "+reponse[0]['nbFollower'];
                $("#nbFollow").html(str);
                $("#div_profilPic").html(img);
                $("#usernameProfil").html(reponse[3]['username']);
                $("#nomProfil").html(nom);
                $("#div_profilPic").append(follow);
            }
        });
    };

    function ajaxCall_retweet(event){
        console.log(event.data)
        // event.preventDefault();
        // data = JSON.stringify(event.data);
        let idTweet = event.data['id_tweet'];
        // idTweet = idTweet.substr(0, idTweet.length-2);


        var requete = $.ajax({
        type: 'POST',
        url: 'controler.php',
        dataType: 'json',
        data: { 'retweet': true, 'content': content, 'id_tweet': idTweet, 'id_user_tweet': idUserT},
        });
            
        requete.done(function(reponse){
            console.log(reponse);
            // console.log(event.data['id_user_tweet']);
            // idContent = '#content'+idTweet;
            // content = $(idContent).html();
            // console.log($(idContent).html())
            // retweet = "RETWEET : "+content;
            // ajaxCall_putContent(retweet, idTweet, event.data['id_user_tweet']);
        });
    }

    // function ajaxCall_putContent(content, idTweet, idUserT){
    //     var requete = $.ajax({
    //     type: 'POST',
    //     url: 'controler.php',
    //     dataType: 'json',
    //     data: { 'content': content, 'id_tweet': idTweet, 'id_user_tweet': idUserT },
    //     });   
        
    //     requete.done(function(reponse){
    //         return reponse;

    //     });
    // }
    
    function ajaxCall_like(event){
        event.preventDefault();
        let blocId = event.target.id;
        idTweet = blocId.substr(4);

        var requete = $.ajax({
        type: 'POST',
        url: 'controler.php',
        dataType: 'json',
        data: { 'like': true, 'id_tweet': idTweet },
        });
        
        requete.done(function(reponse){
            
        });
    }

    function ajaxCall_follow(event){
        console.log(event.data['id_user_follow']);
        data = JSON.stringify(event.data);
        let idUser = data.substr(12);
        idUser = idUser.substr(0, idUser.length-2);

        var requete = $.ajax({
        type: 'POST',
        url: 'controler.php',
        dataType: 'json',
        data: { 'follow': true, 'id_user_follow': idUser },
        });
        
        requete.done(function(reponse){
        
        });
    }

    
    
    console.log('jquery is readyyy :D');
});