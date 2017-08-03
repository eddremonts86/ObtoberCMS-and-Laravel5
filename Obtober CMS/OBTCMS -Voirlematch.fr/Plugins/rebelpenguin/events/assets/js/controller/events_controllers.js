var array_art = [];

$(document).ready(function () {

    //------------------------ Variables globales -------------------//
    var array_art = [];
    var data = "";

    $(".HS_general").click(function () {

        if($(".gnr_sport").hasClass( "hidden" )== true){
            $(".gnr_sport").removeClass("hidden").addClass("show");
            $(".HS_general i").removeClass("fa-plus").addClass("fa-minus");}
        else{
            $(".gnr_sport").removeClass("show").addClass("hidden");
            $(".HS_general i").removeClass("fa-minus").addClass("fa-plus");
        }

    });
    $(".HS_Page").click(function () {
        if($(".gnr_Page").hasClass( "hidden" )== true){
            $(".gnr_Page").removeClass("hidden").addClass("show");
            $(".HS_Page i").removeClass("fa-plus").addClass("fa-minus");}
        else{
            $(".gnr_Page").removeClass("show").addClass("hidden");
            $(".HS_Page i").removeClass("fa-minus").addClass("fa-plus");
        }
    });
    $(".HS_PageD").click(function () {
        if($(".gnr_PageD").hasClass( "hidden" )== true){
            $(".gnr_PageD").removeClass("hidden").addClass("show");
            $(".HS_PageD i").removeClass("fa-plus").addClass("fa-minus");}
        else{
            $(".gnr_PageD").removeClass("show").addClass("hidden");
            $(".HS_PageD i").removeClass("fa-minus").addClass("fa-plus");
        }
    });
    $(".HS_Game").click(function () {
        if($(".gnr_Game").hasClass( "hidden" )== true){
        $(".gnr_Game").removeClass("hidden").addClass("show");
        $(".HS_Game i").removeClass("fa-plus").addClass("fa-minus");}
        else{
            $(".gnr_Game").removeClass("show").addClass("hidden");
            $(".HS_Game i").removeClass("fa-minus").addClass("fa-plus");
        }
    });
    $("#allcountrys").click(function () {
        if($("#allcountrys").hasClass( "fa-plus" )== true){
            $("#conuntrys_list").removeClass("hidden").addClass("show");
            $("#allcountrys").removeClass("fa-plus").addClass("fa-minus");
        }
        else{
            $("#conuntrys_list").removeClass("show ").addClass("hidden");
            $("#allcountrys").removeClass("fa-minus ").addClass("fa-plus");
        }
    });


    //------------------------ Comportamiento incial -------------------//
    $("#edit_tab  input").attr('disabled', true);
    $("#edit_tab textarea").attr('disabled', true);
    $("#article_caption").Editor();
    $("#article_body").Editor();
    $("#gnr_coment").Editor();
    $("#cont_pros").Editor();
    $("#cont_introduction").Editor();
    $("#udv_content").Editor();
    $("#prod_content").Editor();
    $("#lives_content").Editor();
    $("#odds_content").Editor();
    $("#supp_content").Editor();
    $("#bonusser_content").Editor();
    $("#bruger_content").Editor();
    $("#ind_og_content").Editor();
    $("#vores_content").Editor();
    $("#liveb_content").Editor();
    $("#indsat_content").Editor();
    $("#konk_content").Editor();
    $("#img_genr").Editor();
    $("#img_cont").Editor();
    $('#art_data').tablesorter({
        sortForce: [[1, 0]]
    });
    $('#str_pro').tablesorter();


//------------------------ editables -------------------//
    $("button").on("click", function () {
        var id = $(this).context.id;
        var name = $(this).context.name;
        if (id.search('edit_') != -1) {
            $(this).siblings('span').removeClass("hidden").addClass("show");
            $.request('onInitDataStream', {
                data: {id: id},
                beforeSend: function () {
                    $("#resultado").html("Procesando, espere por favor...");
                },
                success: function (response) {

                    if (response.result == true) {

                        if (response.cont_active == 1) {
                            $('#cont_active').attr('checked', true);
                        }
                        else {
                            $('#cont_active').attr('checked', false);
                        }

                        if (response.gnr_active == 1) {
                            $('#gnr_active').attr('checked', true);
                        }
                        else {
                            $('#gnr_active').attr('checked', false);
                        }
                        $('#gnr_label').val(response.gnr_label)
                        $('#gnr_affi').val(response.gnr_affi)
                        $('#gnr_review_butt').val(response.gnr_review_butt)
                        $('#gnr_live_butt').val(response.gnr_live_butt)
                        $('#gnr_sort').val(response.gnr_sort)
                        $('#gnr_rating').val(response.gnr_rating)
                        $('#gnr_coment').Editor("setText", response.gnr_coment)

                        $('#img_genr').Editor("setText", response.img_genr)
                        $('#img_cont').Editor("setText", response.img_cont)

                        $('#meta_title').val(response.meta_title)
                        $('#meta_desc').val(response.meta_desc)
                        $('#meta_keywords').val(response.meta_keywords)

                        $('#cont_pros').Editor("setText", response.cont_pros)
                        $('#cont_introduction').Editor("setText", response.cont_introduction)
                        $('#cont_bonus').val(response.cont_bonus)
                        $('#cont_topbutton').val(response.cont_topbutton)
                        $('#cont_botbutton').val(response.cont_botbutton)
                        $('#cont_affiliate').val(response.cont_affiliate)

                        $('#udv_heading').val(response.udv_heading)
                        $('#udv_ratin').val(response.udv_ratin)
                        $('#udv_content').Editor("setText", response.udv_content)

                        $('#prod_heading').val(response.prod_heading)
                        $('#prod_ratin').val(response.prod_ratin)
                        $('#prod_content').Editor("setText", response.prod_content)

                        $('#lives_heading').val(response.lives_heading)
                        $('#lives_ratin').val(response.lives_ratin)
                        $('#lives_content').Editor("setText", response.lives_content)

                        $('#odds_heading').val(response.odds_heading)
                        $('#odds_ratin').val(response.odds_ratin)
                        $('#odds_content').Editor("setText", response.odds_content)

                        $('#supp_heading').val(response.supp_heading)
                        $('#supp_ratin').val(response.supp_ratin)
                        $('#supp_content').Editor("setText", response.supp_content)

                        $('#bonusser_heading').val(response.bonusser_heading)
                        $('#bonusser_ratin').val(response.bonusser_ratin)
                        $('#bonusser_content').Editor("setText", response.bonusser_content)

                        $('#bruger_heading').val(response.bruger_heading)
                        $('#bruger_ratin').val(response.bruger_ratin)
                        $('#bruger_content').Editor("setText", response.bruger_content)

                        $('#ind_og_heading').val(response.ind_og_heading)
                        $('#ind_og_ratin').val(response.ind_og_ratin)
                        $('#ind_og_content').Editor("setText", response.ind_og_content)

                        $('#vores_heading').val(response.vores_heading)
                        $('#vores_ratin').val(response.vores_ratin)
                        $('#vores_content').Editor("setText", response.vores_content)

                        $('#liveb_heading').val(response.liveb_heading)
                        $('#liveb_ratin').val(response.liveb_ratin)
                        $('#liveb_content').Editor("setText", response.liveb_content)

                        $('#indsat_heading').val(response.indsat_heading)
                        $('#indsat_ratin').val(response.indsat_ratin)
                        $('#indsat_content').Editor("setText", response.indsat_content)

                        $('#konk_heading').val(response.konk_heading)
                        $('#konk_ratin').val(response.konk_ratin)

                        $('#gnr_false').val(response.gnr_false)
                        $('#cont_false_affiliate').val(response.cont_false_affiliate)

                        $('#konk_content').Editor("setText", response.konk_content)
                    }
                    else {
                        $('#respondts_info').modal('show')
                    }
                },
                complete: function () {
                    $("input").attr('disabled', false);
                    $("textarea").attr('disabled', false);
                },
                error: function () {
                    $('#respondts_error').modal('show')
                }

            });
            $('#tbody_list').find('.editable').addClass("hidden");
            $(this).siblings('span').removeClass("show").addClass("hidden");
            $(this).siblings('button').removeClass("hidden").addClass("show ").fadeIn('slow');
        }
        if (id.search('Edtsport_') != -1) {
            $(this).siblings('span').removeClass("hidden").addClass("show");
            $.request('onSportEdit', {
                data: {id: id},
                beforeSend: function () {
                    $("#resultado").html("Procesando, espere por favor...");
                },
                success: function (response) {
                        $('#sport_name').val(response.name)
                        $('#sport_color').val(response.color)
                        $('#sport_url').val(response.gnr_review_butt)
                        $('#sport_id').val(response.id_sport)
                },
                complete: function () {
                    $('#editsport').modal('show')
                },
                error: function () {
                    $('#respondts_error').modal('show')
                }

            });
        }
        if (id.search('sportconf_') != -1) {
            $('#stram_prov_id').val(id);
            var streamid = $('#stram_prov_id').val();
            $(this).siblings('span').removeClass("hidden").addClass("show");
            var tabs_id = $('#tabsport_stream').children('li').children('a');
            tabs_id.each(function (index) {
                var data = $(this).attr("id");
                var data_id = data.split("#");
                var data_id = data_id[1];
                if(data_id != null || data_id != undefined) {
                    /!* -------------- Genera Info ---------------- *!/
                    $('#gnr_label_' + data_id).val("");
                    $('#gnr_aff_' + data_id).val("");
                    $('#gnr_false_aff_' + data_id).val("");
                    $('#gnr_sort_' + data_id).val("");
                    $('#gnr_active_' + data_id).val("");
                    $('#gnr_raiting_' + data_id).val("");
                    $('#gnr_quality_' + data_id).val("");
                    $('#gnr_size_' + data_id).val("");
                    $('#gnr_price_' + data_id).val("");

                    /!* -------------- Stream_general_manager  ---------------- *!/
                    $('#gpm_head_' + data_id).val("");
                    $('#gn_checkbox' + data_id).val("");
                    $('#gpm_quality_head_' + data_id).val("");
                    $('#gpm_quality_content_' + data_id).val("");
                    $('#gpm_udv_head_' + data_id).val("");
                    $('#gpm_udv_content_' + data_id).val("");
                    $('#gpm_price_head_' + data_id).val("");
                    $('#gpm_price_content_' + data_id).val("");
                    $('#gpm_icon_H_one_' + data_id).val("");
                    $('#gpm_icon_S_one_' + data_id).val("");
                    $('#gpm_icon_H_two_' + data_id).val("");
                    $('#gpm_icon_S_two_' + data_id).val("");
                    $('#gpm_icon_H_three_' + data_id).val("");
                    $('#gpm_icon_S_three_' + data_id).val("");
                    $('#gpm_icon_N_three_' + data_id).val("");
                    $('#gpm_button_rew_' + data_id).val("");
                    $('#gpm_button_wlive_' + data_id).val("");
                    $('#gpm_button_aff_' + data_id).val("");
                    $('#gpm_false_button_aff_' + data_id).val("");

                    /!* -------------- Stream_provider_page ---------------- *!/
                    $('#gpp_head_' + data_id).val("");
                    $('#gpp_quality_head_' + data_id).val("");
                    $('#gpp_quality_content_' + data_id).val("");
                    $('#gpp_udv_head_' + data_id).val("");
                    $('#gpp_udv_content_' + data_id).val("");
                    $('#gpp_price_head_' + data_id).val("");
                    $('#gpp_price_content_' + data_id).val("");
                    $('#gpp_icon_H_one_' + data_id).val("");
                    $('#gpp_icon_S_one_' + data_id).val("");
                    $('#gpp_icon_H_two_' + data_id).val("");
                    $('#gpp_icon_S_two_' + data_id).val("");
                    $('#gpp_icon_H_three_' + data_id).val("");
                    $('#gpp_icon_S_three_' + data_id).val("");
                    $('#gpp_icon_note_' + data_id).val("");
                    $('#gpp_button_rew_' + data_id).val("");
                    $('#gpp_button_wlive_' + data_id).val("");
                    $('#gpp_button_aff_' + data_id).val("");
                    $('#gpp_false_button_aff_' + data_id).val("");
                    $('#gpp_button_disclaimer_' + data_id).val("");

                    $('#gpd_points_head_' + data_id).val("");
                    $('#gpd_points_pointOne_' + data_id).val("");
                    $('#gpd_points_pointTwo_' + data_id).val("");
                    $('#gpd_points_pointTree_' + data_id).val("");

                    /!* -------------- Stream_page_details ---------------- *!/
                    $('#gpd_head_' + data_id).val("");
                    $('#gpd_icon_note_' + data_id).val("");
                    $('#gpd_icon_H_one_' + data_id).val("");
                    $('#gpd_icon_S_one_' + data_id).val("");
                    $('#gpd_icon_H_two_' + data_id).val("");
                    $('#gpd_icon_S_two_' + data_id).val("");
                    $('#gpd_icon_H_three_' + data_id).val("");
                    $('#gpd_button_head_' + data_id).val("");
                    $('#gpd_button_subhead_' + data_id).val("");
                    $('#gpd_button_aff_' + data_id).val("");
                    $('#gpd_false_button_aff_' + data_id).val("");
                    $('#gpd_button_disclaimer_' + data_id).val("");
                    /!* -------------- End ---------------- *!/
                    }

                });
            $.request('onUpdateStreamPerSport',{
                        data:{id : id},
                        success: function (response) {
                            var array_art=[];
                            var tabs = $('#tabsport_stream').children('li').children('a');
                            tabs.each(function (index) {
                                var data = response[$(this).attr("title")];
                                if(data != undefined){
                                    var id_sp = (data.id_sport) ? data.id_sport : null;
                                    if(id_sp != null || id_sp != undefined) {
                                        /* -------------- Genera Info ---------------- */
                                        $('#gnr_label_'+id_sp).val(data.gnr_label);
                                        $('#gnr_aff_'+id_sp).val(data.gnr_afflink);
                                        $('#gnr_false_aff_'+id_sp).val(data.gnr_false_aff);
                                        $('#gnr_sort_'+id_sp).val(data.gnr_sort);
                                        $('#gnr_active_'+id_sp).val(data.gnr_active);
                                        $('#gnr_raiting_'+id_sp).val(data.gnr_rating);
                                        $('#gnr_quality_'+id_sp).val(data.gnr_quality);
                                        $('#gnr_size_'+id_sp).val(data.gnr_size);
                                        $('#gnr_price_'+id_sp).val(data.gnr_price);

                                        /* -------------- Stream_general_manager  ---------------- */
                                        $('#gpm_head_'+id_sp).val(data.gpm_head);
                                        $('#gn_checkbox'+id_sp).val(data.gpm_active);
                                        $('#gpm_quality_head_'+id_sp).val(data.gpm_quality_head);
                                        $('#gpm_quality_content_'+id_sp).val(data.gpm_quality_content);
                                        $('#gpm_udv_head_'+id_sp).val(data.gpm_udv_head);
                                        $('#gpm_udv_content_'+id_sp).val(data.gpm_udv_content);
                                        $('#gpm_price_head_'+id_sp).val(data.gpm_price_head);
                                        $('#gpm_price_content_'+id_sp).val(data.gpm_price_content);
                                        $('#gpm_icon_H_one_'+id_sp).val(data.gpm_icon_H_one);
                                        $('#gpm_icon_S_one_'+id_sp).val(data.gpm_icon_S_one);
                                        $('#gpm_icon_H_two_'+id_sp).val(data.gpm_icon_H_two);
                                        $('#gpm_icon_S_two_'+id_sp).val(data.gpm_icon_S_two);
                                        $('#gpm_icon_H_three_'+id_sp).val(data.gpm_icon_H_three);
                                        $('#gpm_icon_S_three_'+id_sp).val(data.gpm_icon_S_three);
                                        $('#gpm_icon_N_three_'+id_sp).val(data.gpm_icon_N_three);
                                        $('#gpm_button_rew_'+id_sp).val(data.gpm_button_rew);
                                        $('#gpm_button_wlive_'+id_sp).val(data.gpm_button_wlive);
                                        $('#gpm_button_aff_'+id_sp).val(data.gpm_button_aff);
                                        $('#gpm_false_button_aff_'+id_sp).val(data.gpm_false_button_aff);

                                        /* -------------- Stream_provider_page ---------------- */
                                        $('#gpp_head_'+id_sp).val(data.gpp_head);
                                        $('#gpp_quality_head_'+id_sp).val(data.gpp_quality_head);
                                        $('#gpp_quality_content_'+id_sp).val(data.gpp_quality_content);
                                        $('#gpp_udv_head_'+id_sp).val(data.gpp_udv_head);
                                        $('#gpp_udv_content_'+id_sp).val(data.gpp_udv_content);
                                        $('#gpp_price_head_'+id_sp).val(data.gpp_price_head);
                                        $('#gpp_price_content_'+id_sp).val(data.gpp_price_content);
                                        $('#gpp_icon_H_one_'+id_sp).val(data.gpp_icon_H_one);
                                        $('#gpp_icon_S_one_'+id_sp).val(data.gpp_icon_S_one);
                                        $('#gpp_icon_H_two_'+id_sp).val(data.gpp_icon_H_two);
                                        $('#gpp_icon_S_two_'+id_sp).val(data.gpp_icon_S_two);
                                        $('#gpp_icon_H_three_'+id_sp).val(data.gpp_icon_H_three);
                                        $('#gpp_icon_S_three_'+id_sp).val(data.gpp_icon_S_three);
                                        $('#gpp_icon_note_'+id_sp).val(data.gpp_icon_note);
                                        $('#gpp_button_rew_'+id_sp).val(data.gpp_button_rew);
                                        $('#gpp_button_wlive_'+id_sp).val(data.gpp_button_wlive);
                                        $('#gpp_button_aff_'+id_sp).val(data.gpp_button_aff);
                                        $('#gpp_false_button_aff_'+id_sp).val(data.gpp_false_button_aff);
                                        $('#gpp_button_disclaimer_'+id_sp).val(data.gpp_button_disclaimer);

                                        $('#gpd_points_head_' + id_sp).val(data.gpd_points_head_);
                                        $('#gpd_points_pointOne_' + id_sp).val(data.gpd_points_pointOne_);
                                        $('#gpd_points_pointTwo_' + id_sp).val(data.gpd_points_pointTwo_);
                                        $('#gpd_points_pointTree_' + id_sp).val(data.gpd_points_pointTree_);

                                        /* -------------- Stream_page_details ---------------- */
                                        $('#gpd_head_'+id_sp).val(data.gpd_head);
                                        $('#gpd_icon_note_'+id_sp).val(data.gpd_icon_note);
                                        $('#gpd_icon_H_one_'+id_sp).val(data.gpd_icon_H_one);
                                        $('#gpd_icon_S_one_'+id_sp).val(data.gpd_icon_S_one);
                                        $('#gpd_icon_H_two_'+id_sp).val(data.gpd_icon_H_two);
                                        $('#gpd_icon_S_two_'+id_sp).val(data.gpd_icon_S_two);
                                        $('#gpd_icon_H_three_'+id_sp).val(data.gpd_icon_H_three);
                                        $('#gpd_icon_S_three_'+id_sp).val(data.gpd_icon_S_three);
                                        $('#gpd_button_head_'+id_sp).val(data.gpd_button_head);
                                        $('#gpd_button_subhead_'+id_sp).val(data.gpd_button_subhead);
                                        $('#gpd_button_aff_'+id_sp).val(data.gpd_button_aff);
                                        $('#gpd_false_button_aff_'+id_sp).val(data.gpd_false_button_aff);
                                        $('#gpd_button_disclaimer_'+id_sp).val(data.gpd_button_disclaimer);

                                        /* -------------- End ---------------- */
                                    }
                                    else {
                                        alert('Algo anda mal.');
                                    }
                                }
                            });
                            $('#stream_sport').modal({backdrop: 'static',keyboard: false})
                            $('#stream_sport').modal('show')
                        },
                        complete: function () {},
                        error: function () {}
                    });
        };
        if (id.search('ok_') != -1) {
            var result = [];
            var gnr_active;
            var cont_active;
            if ($("#gnr_active").is(':checked') == true)
                gnr_active = 1;
            else
                gnr_active = 0;

            if ($("#cont_active").is(':checked') == true)
                cont_active = 1;
            else
                cont_active = 0;

            var gnr_label = $('#gnr_label').val()
            var gnr_affi = $('#gnr_affi').val()
            var gnr_review_butt = $('#gnr_review_butt').val()
            var gnr_live_butt = $('#gnr_live_butt').val()
            var gnr_sort = $('#gnr_sort').val()
            var gnr_rating = $('#gnr_rating').val()
            var gnr_coment = $('#gnr_coment').Editor("getText")
            var img_genr = $('#img_genr').Editor("getText")
            var img_cont = $('#img_cont').Editor("getText")
            var meta_title = $('#meta_title').val()
            var meta_desc = $('#meta_desc').val()
            var meta_keywords = $('#meta_keywords').val()
            var cont_pros = $('#cont_pros').Editor("getText")
            var cont_introduction = $('#cont_introduction').Editor("getText")
            var cont_bonus = $('#cont_bonus').val()
            var cont_topbutton = $('#cont_topbutton').val()
            var cont_botbutton = $('#cont_botbutton').val()
            var cont_affiliate = $('#cont_affiliate').val()
            var udv_heading = $('#udv_heading').val()
            var udv_ratin = $('#udv_ratin').val()
            var udv_content = $('#udv_content').Editor("getText")
            var prod_heading = $('#prod_heading').val()
            var prod_ratin = $('#prod_ratin').val()
            var prod_content = $('#prod_content').Editor("getText")
            var lives_heading = $('#lives_heading').val()
            var lives_ratin = $('#lives_ratin').val()
            var lives_content = $('#lives_content').Editor("getText")
            var odds_heading = $('#odds_heading').val()
            var odds_ratin = $('#odds_ratin').val()
            var odds_content = $('#odds_content').Editor("getText")
            var supp_heading = $('#supp_heading').val()
            var supp_ratin = $('#supp_ratin').val()
            var supp_content = $('#supp_content').Editor("getText")
            var bonusser_heading = $('#bonusser_heading').val()
            var bonusser_ratin = $('#bonusser_ratin').val()
            var bonusser_content = $('#bonusser_content').Editor("getText")
            var bruger_heading = $('#bruger_heading').val()
            var bruger_ratin = $('#bruger_ratin').val()
            var bruger_content = $('#bruger_content').Editor("getText")
            var ind_og_heading = $('#ind_og_heading').val()
            var ind_og_ratin = $('#ind_og_ratin').val()
            var ind_og_content = $('#ind_og_content').Editor("getText")
            var vores_heading = $('#vores_heading').val()
            var vores_ratin = $('#vores_ratin').val()
            var vores_content = $('#vores_content').Editor("getText")
            var liveb_heading = $('#liveb_heading').val()
            var liveb_ratin = $('#liveb_ratin').val()
            var liveb_content = $('#liveb_content').Editor("getText")
            var indsat_heading = $('#indsat_heading').val()
            var indsat_ratin = $('#indsat_ratin').val()
            var indsat_content = $('#indsat_content').Editor("getText")
            var konk_heading = $('#konk_heading').val()
            var konk_ratin = $('#konk_ratin').val()
            var gnr_false = $('#gnr_false').val()
            var cont_false_affiliate = $('#cont_false_affiliate').val()
            var konk_content = $('#konk_content').Editor("getText")
            result = [
                gnr_active,
                gnr_label,
                gnr_affi,
                gnr_review_butt,
                gnr_live_butt,
                gnr_sort,
                gnr_rating,
                gnr_coment,
                meta_title,
                meta_desc,
                meta_keywords,
                cont_pros,
                cont_introduction,
                cont_bonus,
                cont_topbutton,
                cont_botbutton,
                cont_affiliate,
                cont_active,
                udv_heading,
                udv_ratin,
                udv_content,
                prod_heading,
                prod_ratin,
                prod_content,
                lives_heading,
                lives_ratin,
                lives_content,
                odds_heading,
                odds_ratin,
                odds_content,
                supp_heading,
                supp_ratin,
                supp_content,
                bonusser_heading,
                bonusser_ratin,
                bonusser_content,
                bruger_heading,
                bruger_ratin,
                bruger_content,
                ind_og_heading,
                ind_og_ratin,
                ind_og_content,
                vores_heading,
                vores_ratin,
                vores_content,
                liveb_heading,
                liveb_ratin,
                liveb_content,
                indsat_heading,
                indsat_ratin,
                indsat_content,
                konk_heading,
                konk_ratin,
                konk_content,
                img_cont,
                img_genr,
                gnr_false,
                cont_false_affiliate
            ];
            $.request('onFetchDataFromServer', {
                confirm: 'Are you sure?',
                data: {result: result, id: id},
                complete: function () {
                    $('#respondts_succes').modal('show')
                },
                error: function () {
                    $('#respondts_error').modal('show')
                }
            });
        }
        if (id.search('cancel_') != -1) {
            $(this).siblings('.show').removeClass("show").addClass("hidden");
            $(this).removeClass("show").addClass("hidden");
            $("#edit_tab  input").val('');
            $("#edit_tab textarea").val('');
           // $("input").attr('disabled', true);
            $('#gnr_coment').Editor("setText", '');
            $("#cont_pros").Editor("setText", '');
            $("#cont_introduction").Editor("setText", '');
            $("#udv_content").Editor("setText", '');
            $("#prod_content").Editor("setText", '');
            $("#lives_content").Editor("setText", '');
            $("#odds_content").Editor("setText", '');
            $("#supp_content").Editor("setText", '');
            $("#bonusser_content").Editor("setText", '');
            $("#bruger_content").Editor("setText", '');
            $("#ind_og_content").Editor("setText", '');
            $("#vores_content").Editor("setText", '');
            $("#liveb_content").Editor("setText", '');
            $("#indsat_content").Editor("setText", '');
            $("#konk_content").Editor("setText", '');
            $("#img_genr").Editor("setText", '');
            $("#img_cont").Editor("setText", '');
        }
        if (id.search('art_') != -1) {
            var text = $(this).parent().parent().children('.td_art');
            text.each(function (index) {
                array_art[index] = $(this).context.textContent;
            });
            var html_art;
            $('#article_caption').Editor("setText", '');
            $('#article_body').Editor("setText", '');
            $('#article_name').val(array_art[2]);
            $('#sport_id_art').val(array_art[11]);

            //var myarr = mystr.split(":");

            $('#id_eventos').val(id);
            $.request('onLoadArticleData', {
                data: {id: id},
                success: function (response) {
                    if (response.show_front == 1) {
                        $('#article_frontpage').attr('checked', true);
                    }
                    else {
                        $('#article_frontpage').attr('checked', false);
                    }
                    if (response.vip_article == 1) {
                        $('#vip_article').attr('checked', true);
                    }
                    else {
                        $('#vip_article').attr('checked', false);
                    }
                    if (response.permanet_front == 1) {
                        $('#article_prioritize').attr('checked', true);
                    }
                    else {
                        $('#article_prioritize').attr('checked', false);
                    }
                    $('#article_autor').val(response.autor);
                    if (response.name) {
                        $('#article_name').val(response.name);
                    }
                    $('#article_body').Editor("setText", response.article_body)
                    $('#article_caption').Editor("setText", response.caption)
                    var home_img = '<img style="width: 70px;height: 70px;border-radius: 50%;vertical-align: middle;margin: 5px;padding: 4px;background-color: #fff;border: 4px solid #ddd" src=' + array_art[9] + '>';
                    var awey_img = '<img style="width: 70px;height: 70px;border-radius: 50%;vertical-align: middle;margin: 5px;padding: 4px;background-color: #fff;border: 4px solid #ddd" class="img-circle img-thumbnail" src=' + array_art[10] + '>';
                    $('#home_img').html(home_img);
                    $('#awey_img').html(awey_img);
                    $('#vs_team').html('Vs');
                    html_art = '<div class="row"> ' +
                        '<div class="col-md-6"> ' +
                        '<div><b>Match:</b> ' + array_art[2] + '</div>' +
                        '<div><b>Country:</b> ' + array_art[3] + '</div>' +
                        '<div><b>League:</b> ' + array_art[4] + '</div>' +
                        '</div>' +
                        '<div class="col-md-6"> ' +
                        '<div><b>Time:</b> ' + array_art[1] + '</div>' +
                        '<div><b>Date Create:</b> ' + response.date_create + '</div>' +
                        '<div><b>Date Update:</b> ' + response.date_update + '</div>' +
                        '</div>' +
                        '</div><br>';
                    $('#resumen').html(html_art).fadeIn(5000);
                }
            });
        }
        if (id.search('landpage_') != -1) {
           // $(this).siblings('span').removeClass("hidden").addClass("show");
            $('#land_id_name_str_stream').html("Landing Page editor: " + name + id);
            $.request('onUrl', {
                data: {id: id},
                success: function (response) {
                    var buton = ' <a  target="_blank" href="/'+response['sport_name']+'/kamp/:'+response['url_free']+'" class="btn btn-info" >Preview Landin Page</a>';
                    $('#url_view').html(buton)
                },
            });
            $.request('onLandingPage', {
                data: {id: id},
                beforeSend: function () {
                    $("#resultado").html("Procesando, espere por favor...");
                },
                success: function (response) {
                    var tabsid = [];
                    var tabs = $('#land_stream').children('li').children('a');
                    var i=0;
                    tabs.each(function (index) {
                    var data = $(this).attr("title");
                        if(data != undefined && data != 'MetaInformation' ){
                            tabsid[i] = data;
                            i++;
                           }});
                    if(response[0]['error']!= 'error') {
                        for(var z=0; z < tabsid.length; z++ ) {
                            var id_STM = response[z]['id_stp'];
                            if (z == 0)
                            {
                                $('#pagtitle').val('');
                                $('#Token').val();
                                $('#Keywords').val('');
                                $('#Description').val('');
                                $('#Heading').val('');
                                $('#Affiliate').val('');
                                $('#Heading1').val('');
                                $('#OnTV').val('');
                                $('#gnr_checkbox_use').attr('checked', false);
                                $('#gnr_checkbox').attr('checked', false);
                                $('#Sponsoreret').attr('checked', false);
                            }
                                $('#Stream_Heading_' + id_STM).val('');
                                $('#Stream_Aff_' + id_STM).val('');
                                $('#Stream_Content_' + id_STM).val('');
                                $('#Stream_Sort_' + id_STM).val('');
                                $('#Stream_Icon1_' + id_STM).val('');
                                $('#Stream_Icon2_' + id_STM).val('');
                                $('#Stream_Icon3_' + id_STM).val('');
                                $('#Stream_Phrase_' + id_STM).val('');
                                $('#Stream_ButtonText_' + id_STM).val('');
                                $('#Price_' + id_STM).val('');
                                $('#Quality_' + id_STM).val('');
                                $('#Rating_' + id_STM).val('');

                                $('#promobox_' + id_STM).attr('checked', false);
                                $('#Showsponsored_' + id_STM).attr('checked', false);
                                $('#Disclaimer_' + id_STM).attr('checked', false);

                            }
                        for (var z = 0; z < tabsid.length; z++) {
                            var id_STM = response[z]['id_stp'];
                            $('#pagtitle').val(response[z]['pagetitle']);
                            $('#Token').val(response[z]['urltoken']);
                            $('#Keywords').val(response[z]['metakeyb']);
                            $('#Description').val(response[z]['metadescrip']);
                            $('#Heading').val(response[z]['prombox_head']);
                            $('#Affiliate').val(response[z]['prombox_affil']);
                            $('#Heading1').val(response[z]['prombox_banner_head']);
                            $('#Price_').val(response[z]['Price']);
                            $('#Quality_').val(response[z]['Quality']);
                            $('#Rating_').val(response[z]['Rating']);
                            $('#OnTV').val(response[z]['prombox_aff_tv']);

                            if (response[z]['usedarticle'] == 1)$('#gnr_checkbox_use').attr('checked', true);
                            if (response[z]['landingActive'] == 1)$('#gnr_checkbox').attr('checked', true);
                            if (response[z]['Sponsoreret'] == 1)$('#Sponsoreret').attr('checked', true);

                            $('#Stream_Heading_' + id_STM).val(response[z]['stream_head']);
                            $('#Stream_Aff_' + id_STM).val(response[z]['stream_aff']);
                            $('#Stream_Content_' + id_STM).val(response[z]['stream_content']);
                            $('#Stream_Sort_' + id_STM).val(response[z]['stream_sort']);
                            $('#Stream_Icon1_' + id_STM).val(response[z]['stream_icon_one']);
                            $('#Stream_Icon2_' + id_STM).val(response[z]['stream_icon_two']);
                            $('#Stream_Icon3_' + id_STM).val(response[z]['stream_icon_tree']);
                            $('#Stream_Phrase_' + id_STM).val(response[z]['stream_buttons_phrase']);
                            $('#Stream_ButtonText_' + id_STM).val(response[z]['stream_buttons_butt']);
                            $('#Price_' + id_STM).val(response[z]['Price']);
                            $('#Quality_' + id_STM).val(response[z]['Quality']);
                            $('#Rating_' + id_STM).val(response[z]['Rating']);

                            if (response[z]['promobox'] == 1)$('#promobox_' + id_STM).attr('checked', true);
                            if (response[z]['sponsored'] == 1)$('#Showsponsored_' + id_STM).attr('checked', true);
                            if (response[z]['Disclaimer'] == 1)$('#Disclaimer_' + id_STM).attr('checked', true);
                        }
                    }
                    else{
                        var data = $('#tabcontent').children('div').children('div').children('div').children('input');
                        $('#gnr_checkbox_use').attr('checked', true);
                        $('#gnr_checkbox').attr('checked', true);
                        $('#Sponsoreret').attr('checked', true);

                        $(data).each(function (i) {

                            if ($(this).is(':checked')) {
                                $(this).attr('checked', false);
                            }

                            $(this).val('');


                        });
                    }
                },
                complete: function () {
                        $('#landingPageEdit_').modal('show')
                    },
                error: function () {
                        $('#respondts_error').modal('show')
                    }

            });
            $('#id_article').attr('name',id);
            $('#id_article').attr('value',id);
        }
        if (id.search('rest_march_') != -1) {var info = 1;restrictions(this,info);
        }
    });
    $("a").on("click", function () {
        var id = $(this).context.id
        if (id.search('data_') != -1) {
            var data_array = {};
            var data = $(this).siblings('div').children('div').children('div').children('input');
            var stram_prov_id = $('#stram_prov_id').val();
            $(data).each(function (i) {
                if (typeof $(this).attr('name') == 'string' && $(this).attr('name').length > 0) {
                    var name = $(this).attr('name');
                    var value = $(this).val();
                    data_array[name] = value;
                }
            }
            ).promise().done(function () {
                $.request('onStreamDataSports', {
                    confirm: 'Are you sure?',
                    data: {
                        _array: data_array,
                        stram_prov_id: stram_prov_id
                    },
                    success: function (response) {

                    }
                });
            });
        }
        if (id.search('black_') != -1) {
            var info = 2;
            restrictions(this,info);
        }
        if (id.search('black_') != -1) {
            var info = 2;
            restrictions(this,info);
        }
        if (id.search('black_lig_') != -1) {
            $('#restrictions').modal('show')
        }

    })
    $("i").on("click", function () {
        var allid = $(this).context.id;
        var id = allid.split("countrys_");
        var sport = $('#_black_spot_article').val();
        var data='';
        if (allid.search('countrys_') != -1){
            if($(this).hasClass("fa-plus")== true){
                $('#Loaders').modal('show');
                $.request('onGetLigas', {
                    confirm: 'Are you sure?',
                    data: {
                        id:id[1],
                        sport:sport
                    },
                    success: function (response) {
                        if(response[0]['cont']!= 'null'){
                        data='<table class="table table-striped">';
                        for (var a = 0; a < response[0]['cont']; a++) {
                            data += '<tr class="active">' +
                                    '<td class="td_art">' + response[a]['name'] + '</td>' +
                                    '<td class="td_art"> ' +
                                        '<label class="custom-switch">';

                            if(response[a]['act']==1){
                                data += '<input class="" id="rest_lig_' +response[a]['id']+'"  onclick = "restrictionsblack(this,info = 0);" name="rest_lig"' +response[a]['id']+' type="checkbox" checked/>';
                             }else {
                                 data += '<input class="" id="rest_lig_' + response[a]['id'] + '"  onclick = "restrictionsblack(this,info = 0);" name="rest_lig"' + response[a]['id'] + ' type="checkbox"/>' ;
                             }

                            data +='<span><span>On</span>'+
                                        '<span>Off</span></span>'+
                                        '<a class="slide-button"></a></label>'+
                                    '</td>';

                            if(response[a]['actrest']==1){
                                data += '<td class="td_art"> <a id="black_lig_'+response[a]['id']+'" name = "'+response[a]['name']+'" onclick = "restrictions(this,info = 0);" class="pull-right btn btn-success icon-edit edit_show" type="button"></a></td>';
                            }else {
                                data += '<td class="td_art"> <a id="black_lig_'+response[a]['id']+'" name = "'+response[a]['name']+'" onclick = "restrictions(this,info = 0);" class="pull-right btn btn-danger icon-edit edit_show" type="button"></a></td>';
                            }



                                    '</tr>';
                        }
                        data +='</table>';
                        $("#ligas_"+id[1]).html(data);
                        $('#Loaders').modal('hide');
                        $("#ligas_"+id[1]).removeClass("hidden").addClass("show");
                        $('#'+allid).removeClass("fa-plus").addClass("fa-minus");
                        }
                        else {
                            $('#Loaders').modal('hide');
                            $('#modal_titleerror').html('Datos de liga')
                            $('#modal_body_error').html('No tenemos datos para este pais')
                            $('#respondts_error').modal('show')
                        }
                    },
                    error: function () {
                        $('#Loaders').modal('hide');
                        $('#respondts_error').modal('show')
                    }
                });
            }
            else{
                $("#ligas_"+id[1]).removeClass("show ").addClass("hidden");
                $('#'+allid).removeClass("fa-minus ").addClass("fa-plus");
            }
        }
    })
    $("input").on("click", function () {
        var allid = $(this).context.id;
        var value = $(this).context.checked;
        var id_event= $('#id_eventos').val();
        var id_sport= $('#spot_article').val();

        if (allid.search('activepromo_') != -1) {
            $.request('onPromoEvents', {
                    data: {
                        id_stream: allid,
                        id_event:id_event,
                        id_sport:id_sport,
                        value:value
                    },
                    success: function (response) {

                    }});


        }
        if (allid.search('conf_') != -1) {
            $.request('onListStreamEvents', {
                data: {
                    id_stream: allid,
                    id_event:id_event,
                    id_sport:id_sport,
                    value:value
                },
                success: function (response) {

                }});
        }

    })
//------------------------Send Informations -------------------//
    $(".active_btn").on("click", function () {
        var id = $(this).context.id;
        var value = $(this).context.checked;
        $.request('onChangeStatus', {
            confirm: 'Are you sure?',
            data: {id: id, active: value},
            complete: function () {
                $('#respondts_succes').modal('show')
            }

        });
    });
    $("#send_art").on("click", function () {
        var result = [];
        var article_body = $('#article_body').Editor("getText")
        var article_caption = $('#article_caption').Editor("getText")
        var article_frontpage;
        var article_prioritize;
        var vip_article;
        if ($("#article_frontpage").is(':checked') == true) article_frontpage = 1; else article_frontpage = 0;
        if ($("#article_prioritize").is(':checked') == true)  article_prioritize = 1; else article_prioritize = 0;
        if ($("#vip_article").is(':checked') == true)  vip_article = 1; else vip_article = 0;
        var article_name = $('#article_name').val()
        var article_autor = $('#article_autor').val()
        var sport_id_art = $('#sport_id_art').val()
        result[0] = array_art[0];
        result[1] = array_art[1];
        result[2] = array_art[2];
        result[3] = array_art[3];
        result[4] = array_art[4];
        result[5] = array_art[5];
        result[6] = article_body;
        result[7] = article_caption;
        result[8] = article_frontpage;
        result[9] = article_prioritize;
        result[10] = article_name;
        result[11] = article_autor;
        result[12] = array_art[6];
        result[13] = array_art[7];
        result[14] = array_art[8];
        result[15] = vip_article;
        result[16] = array_art[9];
        result[17] = array_art[10];
        result[18] = sport_id_art;

        $.request('onSaveDataArticle', {
            confirm: 'Are you sure?',
            data: {result: result},
            complete: function () {
                $('#respondts_succes').modal('show')
            },
            error: function () {
                $('#respondts_error').modal('show')
            }
        });


    });
    $("#search_time_art").on("click", function () {
        $('#Loaders').modal('show');
        $('#art_match').html('');
        var date_imput = $('#date_imput').val();
        var spot_article = $('#spot_article').val();
        data = "";
        $.request('onUpdateMacht', {
            confirm: 'Are you sure?',
            data: {result: date_imput, sport: spot_article},
            success: function (response) {
                for (var a = 0; a < response[0]['count']; a++) {
                    data += '<tr class="tr_art">' +
                        '<td class="td_art hidden-xs hidden-sm hidden-md">'+response[a]['id_box']+'</td>' +
                        '<td class="td_art hidden-xs hidden-sm hidden-md">'+response[a]['date_hour']+'</td>' +
                        '<td class="td_art">'+response[a]['name']+'</td>'+
                        '<td class="td_art hidden-xs hidden-sm hidden-md">'+response[a]['country']+'</td>' +
                        '<td class="td_art hidden-xs hidden-sm hidden-md">'+response[a]['tournament']+'</td>' +
                        '<td class="td_art hidden">'+response[a]['id']+'</td>' +
                        '<td class="td_art hidden">'+response[a]['date']+'</td>' +
                        '<td class="td_art hidden">'+response[a]['home_team']+'</td>' +
                        '<td class="td_art hidden">'+response[a]['away_team']+'</td>' +
                        '<td class="td_art hidden">'+response[a]['home_team_logo']+'</td>' +
                        '<td class="td_art hidden">'+response[a]['away_team_logo']+'</td>' +
                        '<td class="td_art hidden">'+response[a]['sport_id']+'</td>' +
                        '<td class="list-checkbox nolink">'+
                        '<label class="custom-switch">';
                         if (response[a]['showcase']== 1){
                             data +='<input class="landing_" name="'+response[a]['name']+'" id="landing_'+response[a]['id']+'" onclick="Showsponsored(this,info = 0);" type="checkbox" checked/>'+
                                 '<span><span>On</span>'+
                                 '<span>Off</span></span>'+
                                 '<a class="slide-button"></a>'+
                                 '</label>'+
                                 '</td><td>';
                        }
                         else {
                             data +='<input class="landing_" name="'+response[a]['name']+'" id="landing_'+response[a]['id']+'" onclick="Showsponsored(this,info = 0);" type="checkbox"/>'+
                                 '<span><span>On</span>'+
                                 '<span>Off</span></span>'+
                                 '<a class="slide-button"></a>'+
                                 '</label>'+
                                 '</td><td>';
                        }
                        var id_f = response[a]['id'];
                        if (response[a]['id_event_result'] == '1') {
                            data += '<button id="art_' + response[a]['id'] + '" onclick="myFunction(this,info = 0);"   class="btn btn-warning icon-edit edit_show" type="button"></button>';
                        }
                        else {
                            data += '<button id="art_' + response[a]['id'] + '" onclick = "myFunction(this,info = 0);"   class="btn btn-primary icon-edit edit_show" type="button"></button>';
                        }
                        if (response[a]['mine'] == 'true') {
                                data += '</td></tr>'+
                                '<tr  class="hidden-xs hidden-sm hidden-md">'+
                                '<td>Preview URLs</td>' +
                                '<td colspan="2">'+
                                    '<a class="btn btn-info btn-sm" target="_blank" href="/'+response[a]['sport_name']+'/:'+response[a]['url_free']+'"><b>Game Page URL</b>'+
                                '</a></td>'+
                                '<td colspan="2">'+
                                    '<a  class="btn btn-info btn-sm"  target="_blank" href="/'+response[a]['sport_name']+'/kamp/:'+response[a]['url_free']+'"><b> Landing  Page URL</b>'+
                                '</a></td>'+
                                '<td colspan="2" >'+
                                    '<a  class="btn btn-info btn-sm"  target="_blank" href="/'+response[a]['sport_name']+'/'+response[a]['sport_name']+'_liveevents/:'+response[a]['url_free']+'"><b>  Showcase  Page URL</b>'+
                                '</a></td>'+
                                '</tr>';
                        }
                }
            },
            complete: function () {
                $('#art_match').html(data);
                $('#Loaders').modal('hide');
                $('#respondts_succes').modal('show');

            },
            error: function () {
                $('#Loaders').modal('hide');
                $('#respondts_error').modal('show')
            }
        });
    })
    $("#cancel_art").on("click", function () {
    });
    $("#update_stP").on("click", function () {
        $.request('onUpdateSTP', {
            confirm: 'Are you sure?',
            data: {},
            success: function (response) {
                $('#respondts_succes').modal('show');
            },
            error: function () {
                $('#respondts_error').modal('show')
            }
        });
    });
    /*----------------General Tap------------------*/
    $(".active_btn_sport").on("click", function () {
        var id = $(this).context.id;
        var value = $(this).context.checked;
        var name = $(this).context.name;
        $.request('onChangeStatusSport', {
            confirm: 'Are you sure?',
            data: {id: id, active: value, name: name},
            complete: function () {
                $('#respondts_succes').modal('show')
            }

        });
    });
    $(".landing_").on("click", function () {
        var id = $(this).context.id;
        var text = $(this).parent().parent().parent().children('.td_art');
        text.each(function (index) {
            array_art[index] = $(this).context.textContent;
        });
        $.request('onLandingPagesh', {
           /*confirm: 'Are you sure?',*/
            data: {
                   id : id,
                   array_ : array_art
            },
            complete: function () {$('#respondts_succes').modal('show')}
            }
        );
    });
    $("#sport_save").on("click", function () {
        var name = $('#sport_name').val();
        var id = $('#sport_id').val();
        var color = $('#sport_color').val();
        $.request('onUpdateSports', {
            confirm: 'Are you sure?',
            data: {name: name, id: id, color: color},
            complete: function () {
                $('#editsport').modal('hide')
                $('#respondts_succes').modal('show')
            }

        });
    });
    $("#save_landing_Page").on("click", function () {
        var data_array = {};
        var data = $('#tabcontent').children('div').children('div').children('div').children('input');
        var gnr_checkbox_use = 0;
        var gnr_checkbox = 0;
        var Sponsoreret = 0;
        if ($("#gnr_checkbox_use").is(':checked') == true) gnr_checkbox_use = 1;
        if ($("#gnr_checkbox").is(':checked') == true) gnr_checkbox = 1;
        if ($("#Sponsoreret").is(':checked') == true) Sponsoreret = 1;
        var artid =   $('#id_article').attr('name');
        $(data).each(function (i) {
            if (typeof $(this).attr('name') == 'string' && $(this).attr('name').length > 0) {
                var name = $(this).attr('name');
                if ($(this).attr('name').search('promobox_') != -1){
                    var promobox_;
                    if ($(this).is(':checked') == true) promobox_ = 1; else promobox_ = 0;
                    var value = promobox_;
                }
                else  if ($(this).attr('name').search('Disclaimer_') != -1){
                    var Disclaimer_;
                    if ($(this).is(':checked') == true) Disclaimer_ = 1; else Disclaimer_ = 0;
                    var value = Disclaimer_;
                }
                else if ($(this).attr('name').search('Showsponsored_') != -1){
                    var Showsponsored_;
                    if ($(this).is(':checked') == true) Showsponsored_ = 1; else Showsponsored_ = 0;
                    var value = Showsponsored_;
                }
                else{
                var value = $(this).val();
                }
                data_array[name] = value;
            }
        });
        $.request('onLandingPagesave', {
            confirm: 'Are you sure?',
            data: {
                data_array:data_array,
                gnr_checkbox:gnr_checkbox,
                gnr_checkbox_use:gnr_checkbox_use,
                Sponsoreret:Sponsoreret,
                id:artid
            },
            complete: function () {
                $('#landingPageEdit_').modal('hide')
                $('#respondts_succes').modal('show')
            }

        });
    });
    $("#search_events").on("click", function () {
        $('#Loaders').modal('show');
        $('#black_march_data').html('');
        var date_imput = $('#black_date_imput').val();
        var spot_article = $('#_black_spot_article').val();
        data = "";
        $.request('onUpdateMacht', {
            confirm: 'Are you sure?',
            data: {result: date_imput, sport: spot_article},
            success: function (response) {
                for (var a = 0; a < response[0]['count']; a++) {
                    data += '<tr class="tr_art">' +
                        '<td class="td_art hidden-xs hidden-sm hidden-md">' + response[a]['id_box'] + '</td>' +
                        '<td class="td_art hidden-xs hidden-sm hidden-md">' + response[a]['date_hour'] + '</td>' +
                        '<td class="td_art">' + response[a]['name'] + '  </td>' +
                        '<td class="td_art hidden-xs hidden-sm hidden-md"> ' + response[a]['country'] + ' </td>' +
                        '<td class="td_art hidden-xs hidden-sm hidden-md">' + response[a]['tournament'] + '</td>' +
                        '<td class="td_art hidden">' + response[a]['id'] + ' </td>' +
                        '<td class="td_art hidden">' + response[a]['date'] + ' </td>' +
                        '<td class="td_art hidden">' + response[a]['home_team'] + ' </td>' +
                        '<td class="td_art hidden">' + response[a]['away_team'] + ' </td>' +
                        '<td class="td_art hidden">' + response[a]['home_team_logo'] + ' </td>' +
                        '<td class="td_art hidden">' + response[a]['away_team_logo'] + ' </td>' +
                        '<td class="td_art hidden">' + response[a]['sport_id'] + ' </td>' +
                        '<td class="list-checkbox nolink">'+
                        '<label class="custom-switch">';
                    if (response[a]['blockevent']== 1){
                        data +='<input class="" name="'+response[a]['name']+'" id="back_march_'+response[a]['id']+'" onclick="restrictionsblack(this,info = 1);" type="checkbox" checked/>'+
                            '<span><span>On</span>'+
                            '<span>Off</span></span>'+
                            '<a class="slide-button"></a>'+
                            '</label>'+
                            '</td><td>';
                    }
                    else {
                        data +='<input class="" name="'+response[a]['name']+'" id="back_march_'+response[a]['id']+'" onclick="restrictionsblack(this,info = 1);" type="checkbox"/>'+
                            '<span><span>On</span>'+
                            '<span>Off</span></span>'+
                            '<a class="slide-button"></a>'+
                            '</label>'+
                            '</td><td>';
                    }

                    var id_f = response[a]['id'];
                    if (response[a]['active_rest'] == '1') {
                        data += '<button id="rest_march_' + response[a]['id'] + '" onclick="restrictions(this,info = 1);"   class="btn btn-success icon-edit edit_show" type="button"></button>';
                    }
                    else {
                        data += '<button id="rest_march_' + response[a]['id'] + '" onclick = "restrictions(this,info = 1);"   class="btn btn-danger icon-edit edit_show" type="button"></button>';
                    }
                }
            },
            complete: function () {
                $('#black_march_data').html(data);
                $('#Loaders').modal('hide');
                $('#respondts_succes').modal('show');

            },
            error: function () {
                $('#Loaders').modal('hide');
                $('#respondts_error').modal('show')
            }
        });
    })

    $("#conf_art").on("click", function () {
        var id_event= $('#id_eventos').val();
        var id_sport= $('#spot_article').val();
        $.request('onLoadStream', {
            confirm: 'Are you sure?',
            data: {id_event: id_event, id_sport: id_sport},
            success: function (response) {
                var http='';
                for (var a = 0; a < response[0]['count']; a++) {
                    /*http += '<tr><td>'+
                     '<div class="form-group checkbox-field span-left is-required">'+
                     '<div class="checkbox custom-checkbox">'+
                     '<input name="checkbox" value="1" type="checkbox" id="activepromo_'+response[a].id_stp+'?>">'+
                     '<label for="activepromo_'+response[a].id_stp+'"></label>'+
                     '</div></div></td>'+
                     '<td>'+
                     '<div class="form-group checkbox-field span-left is-required">'+
                     '<div class="checkbox custom-checkbox">'+
                     '<input name="checkbox" value="1" type="checkbox" id="conf_'+response[a].id_stp+'">'+
                     '<label for="conf_'+response[a].id_stp+'"> '+response[a].name+ '</label>'+
                     '</div></div></td>' +
                     '</tr>'
                     }
                     $('#ConfProvider_body').html(http);*/

                    if (response[a].promo_active == 1) {
                        $('#activepromo_'+response[a].id_stp+'').attr('checked', true);
                    }
                    else {
                        $('#activepromo_'+response[a].id_stp+'').attr('checked', false);
                    }

                    if (response[a].promo_stream == 1) {
                        $('#conf_'+response[a].id_stp+'').attr('checked', true);
                    }
                    else {
                        $('#conf_'+response[a].id_stp+'').attr('checked', false);
                    }


                }

            },
            complete: function () {
                $('#ConfProvider').modal('show');
            },
            error: function () {
                $('#Loaders').modal('hide');
                $('#respondts_error').modal('show')
            }
        });

    });
    $("#updateEvents").on("click", function () {
        $.request('onSyncEvents', {
            confirm: 'Are you sure?',
            success: function (response) {
                $('#Loaders').modal('hide');
                $('#respondts_succes').modal('show')
            },
            error: function () {
                $('#Loaders').modal('hide');
                $('#respondts_error').modal('show')
            }
        });

    });

})

function myFunction(_this, info) {
    if (info == '0') {
        var id = _this.id;
        var text = $(_this).parent().parent().children('.td_art');
        text.each(function (index) {
            array_art[index] = $(this).context.textContent;
        });
        var html_art;
        $('#id_eventos').val(id);
        $('#article_name').val(array_art[2]);
        $('#article_caption').Editor("setText", '');
        $('#article_body').Editor("setText", '');

        $('#sport_id_art').val(array_art[11]);
        $.request('onLoadArticleData', {
            data: {id: id},
            success: function (response) {
                if (response.show_front == 1) {
                    $('#article_frontpage').attr('checked', true);
                }
                else {
                    $('#article_frontpage').attr('checked', false);
                }
                if (response.vip_article == 1) {
                    $('#vip_article').attr('checked', true);
                }
                else {
                    $('#vip_article').attr('checked', false);
                }
                if (response.permanet_front == 1) {
                    $('#article_prioritize').attr('checked', true);
                }
                else {
                    $('#article_prioritize').attr('checked', false);
                }
                $('#article_autor').val(response.autor);
                if (response.name) {
                    $('#article_name').val(response.name);
                }
                $('#article_body').Editor("setText", response.article_body)
                $('#article_caption').Editor("setText", response.caption)
                var home_img = '<img style="width: 70px;height: 70px;border-radius: 50%;vertical-align: middle;margin: 5px;padding: 4px;background-color: #fff;border: 4px solid #ddd" src=' + array_art[9] + '>';
                var awey_img = '<img style="width: 70px;height: 70px;border-radius: 50%;vertical-align: middle;margin: 5px;padding: 4px;background-color: #fff;border: 4px solid #ddd" class="img-circle img-thumbnail" src=' + array_art[10] + '>';
                $('#home_img').html(home_img);
                $('#awey_img').html(awey_img);
                $('#vs_team').html('Vs');
                html_art = '<div class="row"> ' +
                    '<div class="col-md-6"> ' +
                    '<div><b>Match:</b>'+ array_art[2]+'</div>' +
                    '<div><b>Country:</b>'+ array_art[3]+'</div>' +
                    '<div><b>League:</b>'+ array_art[4]+'</div>' +
                    '</div>' +
                    '<div class="col-md-6"> ' +
                    '<div><b>Time:</b> '+ array_art[1]+ '</div>' +
                    '<div><b>Date Create:</b> '+ response.date_create +'</div>' +
                    '<div><b>Date Updated:</b> '+ response.date_update +'</div>' +
                    '</div>' +
                    '</div><br>';
                var btn = '<a class="btn btn-success" onclick="myFunction(this,info = array_art);"> Send</a>  <a class="btn btn-danger" id="cancel_art"> Cancel</a>';
                $('#group_btn').html(btn)
                $('#resumen').html(html_art).fadeIn(5000);
            }
        });
    }
    else {
        var result = [];
        var article_body = $('#article_body').Editor("getText")
        var article_caption = $('#article_caption').Editor("getText")
        var article_frontpage;
        var article_prioritize;
        var vip_article;
        if ($("#article_frontpage").is(':checked') == true) article_frontpage = 1; else article_frontpage = 0;
        if ($("#article_prioritize").is(':checked') == true)  article_prioritize = 1; else article_prioritize = 0;
        if ($("#vip_article").is(':checked') == true)  vip_article = 1; else vip_article = 0;
        var article_name = $('#article_name').val()
        var article_autor = $('#article_autor').val()
        var sport_id_art = $('#sport_id_art').val()
        result[0] = info[0];
        result[1] = info[1];
        result[2] = info[2];
        result[3] = info[3];
        result[4] = info[4];
        result[5] = info[5];
        result[6] = article_body;
        result[7] = article_caption;
        result[8] = article_frontpage;
        result[9] = article_prioritize;
        result[10] = article_name;
        result[11] = article_autor;
        result[12] = info[6];
        result[13] = info[7];
        result[14] = info[8];
        result[15] = vip_article;
        result[16] = info[9];
        result[17] = info[10];
        result[18] = sport_id_art;

        $.request('onSaveDataArticle', {
            confirm: 'Are you sure?',
            data: {result: result},
            complete: function () {
                $('#respondts_succes').modal('show')
            },
            error: function () {
                $('#respondts_error').modal('show')
            }
        });
    }
}
function Showsponsored(_this,info){
        var id = _this.id;
        var text =$(_this).parent().parent().parent().children('.td_art');
        text.each(function (index) { array_art[index] = $(this).context.textContent;});
        $.request('onLandingPagesh', {
                confirm: 'Are you sure?',
                data: {
                    id : id,
                    array_ : array_art
                },
                complete: function () {$('#respondts_succes').modal('show')}
            }
        );
}
function restrictionsblack(_this,info){
    if(info==0){
        var id = _this.id;
        var buttom =  $(_this).is(':checked');
        if(buttom== true){buttom = 1;}else{buttom=0;}
        $.request('onUpdaterest', {
            data: {
                id:id,
                buttom:buttom,
                info:info
            },
            success: function (response) {

            }
        })
    }
    if(info==1){
        var id = _this.id;
        var buttom =  $(_this).is(':checked');
        if(buttom== true){buttom = 1;}else{buttom=0;}
        $.request('onUpdaterest', {
            data: {
                id:id,
                buttom:buttom,
                info:info
            },
            success: function (response) {

            }
        })
    }
}
function restrictions(_this,info){
    var id = _this.id;
    var name = _this.name;
    var data='';
    if(info == 0){$('#rest_str_stream').html('Restrictions for league -  '+ name );}
    if(info == 1){$('#rest_str_stream').html('Restrictions for Event -  '+ name );}
    if(info == 2){$('#rest_str_stream').html('Restrictions for Country -  '+ name );}
    $.request('onLoadstreamperall', {
        data: {id:id,info:info},
        success: function (response) {
            if(response[0]['cont']!= 'null'){
                for (var a = 0; a < response[0]['cont']; a++) {
                    var info = response[a]['id_stp'];
                    data += '<tr class="active">' +
                    '<td class="td_art"> ' +
                    '<label class="custom-switch">';
                    if(response[a]['active']==1){
                        data += '<input class="" id="all_stream_' +response[a]['id_stp']+'"  value = '+response[a]['info']+'  onclick = "restrictionsstreams(this);" name='+response[a]['id_all']+' type="checkbox" checked/>';
                    }else {
                        data += '<input class="" id="all_stream_' + response[a]['id_stp'] + '"  value = '+response[a]['info']+'   onclick = "restrictionsstreams(this);" name='+ response[a]['id_all'] + ' type="checkbox"/>' ;
                    }
                    data +='<span><span>On</span>'+
                        '<span>Off</span></span>'+
                        '<a class="slide-button"></a></label>'+
                        '</td>' +
                        '<td class="td_art">' + response[a]['name'] + '</td>' +
                        '</tr>';
                }
                $('#qtbody_list').html(data);
            }

        },
        error: function () {
            $('#respondts_error').modal('show')
        }
    });
    $('#restrictions').modal('show')
}
function restrictionsstreams(_this){
    var id_stream = _this.id;
    var info = _this.value;
    var id_all = _this.name;
    var idsport =  $("#_black_spot_article").val();

    var buttom =  $(_this).is(':checked');
    if(buttom== true){buttom = 1;}else{buttom=0;}
    $.request('onRestrictionsstreams', {
            confirm: 'Are you sure?',
            data: {
                id:id_all,
                id_stream:id_stream,
                info:info,
                buttom:buttom,
                idsport:idsport
            },
            success: function (response) {

            }
        })


}


/**
 * Created by eddy on 30/11/2015.
 */