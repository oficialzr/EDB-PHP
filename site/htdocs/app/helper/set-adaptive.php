<?php include "../database/db.php" ?>
<?php include "../helper/check.php" ?>

<?php



if (isset($_GET['name'])) {
	$gets = $_GET;
	if ($gets['value'] === '' || $gets['name'] === 'represent') {
		echo json_encode(array('data'=>'500'));
		die();
	}
	$n = $_GET['name'];
	$v = $_GET['value'];

	$names = array('entity'=>'division', 'division'=>'filial', 'filial'=>'represent');
	$name = $names["$n"];


	$a = array();

	$b = selectOne("$n", array('name'=>$v));
	$b_index = $b["id_" . "$n"];

	$q = selectAll("$name", array("id_$n"=>$b_index));
	$i = 0;
	foreach ($q as $key => $value) {
		$a[$i] = $value['name'];
		$i++;
	}

	echo json_encode(array('data'=>$a));

}

// if 'name' in request.GET:
//         gets = request.GET
//         if gets['value'] == '':
//             return JsonResponse(data={'data': '500'}) 
//         if gets['name'] == 'entity':
//             a = [i.name for i in Division.objects.filter(id_entity=Entity.objects.get(name=gets['value']))]
//             return JsonResponse(data={'data': a})
//         elif gets['name'] == 'division':
//             a = [i.name for i in Filial.objects.filter(id_division=Division.objects.get(name=gets['value']))]
//             return JsonResponse(data={'data': a})
//         elif gets['name'] == 'filial':
//             a = [i.name for i in Representation.objects.filter(id_filial=Filial.objects.get(name=gets['value']))]
//             return JsonResponse(data={'data': a})
//         else:
//             return JsonResponse(data={'status': '500'})
//     else:
//         return redirect(request, 'home')

die();