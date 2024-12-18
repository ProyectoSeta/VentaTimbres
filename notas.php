////////////////////////// FORMA 14
                    $exist_tfe = true;

                    $nro_timbre = '';
                    $id_rollo = '';

                    //////////// BUSCAR CORRELATIVO
                    $c1 = DB::table('detalle_venta_tfes')->select('nro_timbre','key_rollo')->orderBy('correlativo', 'desc')->first();
                    if ($c1) {
                        /////////hay registro de ventas
                        $nro_hipotetico= $c1->nro_timbre + 1; 

                        $c2 = DB::table('inventario_rollos')->select('hasta','vendido')->where('id_rollo','=',$c1->key_rollo)->first();
                        if ($c2->hasta >= $nro_hipotetico) {
                            ///////// el nro sigue dentro del rango del rollo
                            $nro_timbre = $nro_hipotetico;
                            $id_rollo = $c1->key_rollo;

                            if ($c2->hasta == $nro_timbre) {
                                $update_rollo = DB::table('inventario_rollos')->where('id_rollo','=',$c1->key_rollo)->update(['condicion' => 7]);
                            }

                            $new_vendido = $c2->vendido + 1;
                            $update_vendido = DB::table('inventario_rollos')->where('id_rollo','=',$c1->key_rollo)->update(['vendido' => $new_vendido]);
                        }else{
                            //////// Buscar el siguiente rollo asignado
                            $c3 = DB::table('inventario_rollos')->select('desde','id_rollo')->where('key_taquilla','=',$id_taquilla)->where('condicion','=', 4)->first();
                            if ($c3) {
                                $nro_timbre = $c3->desde;
                                $id_rollo = $c3->id_rollo;

                                
                                $update_vendido = DB::table('inventario_rollos')->where('id_rollo','=',$c3->id_rollo)->update(['vendido' => 1, 'condicion' => 3]);
                            }else{
                                return response()->json(['success' => false, 'nota'=> 'Disculpe, no tiene rollos disponibles asignados a su taquilla.']);
                            }
                        }
                    }else{
                        /////////primera venta a realizarse
                        $c4 = DB::table('inventario_rollos')->select('desde','id_rollo')->where('key_taquilla','=',$id_taquilla)->where('condicion','=', 4)->first();
                        if ($c4) {
                            $nro_timbre = $c4->desde;
                            $id_rollo = $c4->id_rollo;

                            $update_vendido = DB::table('inventario_rollos')->where('id_rollo','=',$c4->id_rollo)->update(['vendido' => 1, 'condicion' => 3]);
                        }else{
                            return response()->json(['success' => false, 'nota'=> 'Disculpe, no tiene rollos disponibles asignados a su taquilla.']);
                        }
                    }

                    //////////////// INSERT DETALLE 
                    $key_tramite = $tramite['tramite'];
                
                    if ($key_tramite == 9) {
                        $metros = $request->post('metros');

                        if ($metros > 0 && $metros <= 150) {
                            ////pequeña
                            $consulta = DB::table('tramites')->select('small')->where('id_tramite','=', $key_tramite)->first();
                            $ucd_tramite = $consulta->small;
                        }elseif ($metros > 150 && $metros < 400) {
                            /////mediana
                            $consulta = DB::table('tramites')->select('medium')->where('id_tramite','=', $key_tramite)->first();
                            $ucd_tramite = $consulta->medium;
                        }elseif ($metros >= 400) {
                            /////grande
                            $consulta = DB::table('tramites')->select('large')->where('id_tramite','=', $key_tramite)->first();
                            $ucd_tramite = $consulta->large;
                        }                  
    
                        $total_ucd = $total_ucd + $ucd_tramite;

                    }else{
                        if ($condicion_sujeto == 10 || $condicion_sujeto == 11) {
                            //////juridico (firma personal - empresa)
                            $consulta = DB::table('tramites')->select('juridico')->where('id_tramite','=', $key_tramite)->first();
                            $ucd_tramite = $consulta->juridico;
                        }else{
                            ////natural
                            $consulta = DB::table('tramites')->select('natural')->where('id_tramite','=', $key_tramite)->first();
                            $ucd_tramite = $consulta->natural;
                        }
                        $total_ucd = $total_ucd + $ucd_tramite;
                    }

                    //// buscar key denominacions
                    $q4 = DB::table('ucd_denominacions')->select('id')->where('denominacion','=',$ucd_tramite)->first();
                    $key_denominacion = $q4->id;

                    ////insert y QR
                    $url = 'https://forma14.tributosaragua.com.ve/?id='.$nro_timbre; 
                    QrCode::format('png')->size(180)->eye('circle')->generate($url, public_path('assets/qrForma14/qrcode_TFE'.$nro_timbre.'.png'));
                    
                    $i2 =DB::table('detalle_venta_tfes')->insert([
                                                                'key_denominacion' => $key_denominacion, 
                                                                'nro_timbre' => $nro_timbre,
                                                                'key_tramite' => $key_tramite,
                                                                'qr' => 'assets/qrForma14/qrcode_TFE'.$nro_timbre.'.png',
                                                                'key_rollo' => $id_rollo]);
                    if ($i2) {
                        $id_correlativo_detalle = DB::table('detalle_venta_tfes')->max('correlativo');
                        array_push($array_correlativo_tfe,$id_correlativo_detalle);

                        $cant_tfe = $cant_tfe + 1;
                        $cant_ucd_tfe = $cant_ucd_tfe + $ucd_tramite;

                        $length = 6;
                        $formato_nro_timbre = substr(str_repeat(0, $length).$nro_timbre, - $length);

                        $row_timbres .= '<div class="border mb-4 rounded-3">
                                <div class="d-flex justify-content-between px-3 py-2 align-items-center">
                                    <!-- DATOS -->
                                    <div class="">
                                        <div class="text-danger fw-bold fs-4" id="">A-'.$formato_nro_timbre.'<span class="text-muted ms-2">TFE-14</span></div> 
                                        <table class="table table-borderless table-sm">
                                            <tr>
                                                <th>Ente:</th>
                                                <td>'.$consulta_tramite->ente.'</td>
                                            </tr>
                                            <tr>
                                                <th>Tramite:</th>
                                                <td>'.$consulta_tramite->tramite.'</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <!-- UCD -->
                                    <div class="">
                                        <div class="text-center titulo fw-bold fs-3">'.$ucd_tramite.' UCD</div>
                                    </div>
                                    <!-- QR -->
                                    <div class="text-center">
                                        <img src="'.asset('assets/qrForma14/qrcode_TFE'.$nro_timbre.'.png').'" class="img-fluid" alt="" width="110px">
                                    </div>
                                </div>
                            </div>';
                    }else{
                        return response()->json(['success' => false]);
                    } 
                    