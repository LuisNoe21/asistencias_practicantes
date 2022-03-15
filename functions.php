<?php
?>
<?php
function getPracticantesWithAttendanceCount($start, $end)
{
    $query = "select practicantes.name, 
sum(case when status = 'presence' then 1 else 0 end) as presence_count,
sum(case when status = 'absence' then 1 else 0 end) as absence_count 
 from practicante_attendance
 inner join practicantes on practicantes.id = practicante_attendance.practicante_id
 where date >= ? and date <= ?
 group by practicante_id;";
    $db = getDatabase();
    $statement = $db->prepare($query);
    $statement->execute([$start, $end]);
    return $statement->fetchAll();
}

function saveAttendanceData($date, $practicantes)
{
    deleteAttendanceDataByDate($date);
    $db = getDatabase();
    $db->beginTransaction();
    $statement = $db->prepare("INSERT INTO practicante_attendance(
        practicante_id,
        date,
        status,
        hentrada,
        hsalida,
        permiso
    ) VALUES (?, ?, ?, ?, ?, ?)");
    foreach ($practicantes as $practicante) {
        $statement->execute([
            $practicante->id,
            $date,
            $practicante->status,
            $practicante->hentrada,
            $practicante->hsalida,
            $practicante->permiso === true ? 1 : 0
        ]);
    }
    $db->commit();
    return true;
}

function deleteAttendanceDataByDate($date)
{
    $db = getDatabase();
    $statement = $db->prepare("DELETE FROM practicante_attendance WHERE date = ?");
    return $statement->execute([$date]);
}
function getAttendanceDataByDate($date)
{
    $db = getDatabase();
    $statement = $db->prepare("SELECT practicante_id, status, hentrada, hsalida, permiso FROM practicante_attendance WHERE date = ?");
    $statement->execute([$date]);
    return $statement->fetchAll();
}


function deletePracticante($id)
{
    $db = getDatabase();
    $statement = $db->prepare("DELETE FROM practicantes WHERE id = ?");
    return $statement->execute([$id]);
}

function updatePracticante($name, $id)
{
    $db = getDatabase();
    $statement = $db->prepare("UPDATE practicantes SET name = ? WHERE id = ?");
    return $statement->execute([$name, $id]);
}
function getPracticanteById($id)
{
    $db = getDatabase();
    $statement = $db->prepare("SELECT id, name FROM practicantes WHERE id = ?");
    $statement->execute([$id]);
    return $statement->fetchObject();
}

function savePracticante($name)
{
    $db = getDatabase();
    $statement = $db->prepare("INSERT INTO practicantes(name) VALUES (?)");
    return $statement->execute([$name]);
}

function getPracticantes()
{
    $db = getDatabase();
    $statement = $db->query("SELECT id, name FROM practicantes");
    return $statement->fetchAll();
}

function getVarFromEnvironmentVariables($key)
{
    if (defined("_ENV_CACHE")) {
        $vars = _ENV_CACHE;
    } else {
        $file = "env.php";
        if (!file_exists($file)) {
            throw new Exception("The environment file ($file) does not exists. Please create it");
        }
        $vars = parse_ini_file($file);
        define("_ENV_CACHE", $vars);
    }
    if (isset($vars[$key])) {
        return $vars[$key];
    } else {
        throw new Exception("The specified key (" . $key . ") does not exist in the environment file");
    }
}

function getDatabase()
{
    $password = getVarFromEnvironmentVariables("MYSQL_PASSWORD");
    $user = getVarFromEnvironmentVariables("MYSQL_USER");
    $dbName = getVarFromEnvironmentVariables("MYSQL_DATABASE_NAME");
    $database = new PDO('mysql:host=localhost;dbname=' . $dbName, $user, $password);
    $database->query("set names utf8;");
    $database->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $database->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    return $database;
}
