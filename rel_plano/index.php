<?php
// INCLUE FUNCOES DE ADDONS -----------------------------------------------------------------------
include('addons.class.php');

// Verifica se o usuário está logado
session_name('mka');
if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['mka_logado']) && !isset($_SESSION['MKA_Logado'])) exit('Acesso negado... <a href="/admin/login.php">Fazer Login</a>');

// Variáveis do Manifesto
$manifestTitle = isset($Manifest->name) ? htmlspecialchars($Manifest->name) : '';
$manifestVersion = isset($Manifest->version) ? htmlspecialchars($Manifest->version) : '';
?>

<!DOCTYPE html>
<html lang="pt-BR" class="has-navbar-fixed-top">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <title>MK - AUTH :: <?php echo $Manifest->{'name'} . " - V " . $Manifest->{'version'}; ?></title>

    <!-- CSS Files -->
    <link href="../../estilos/mk-auth.css" rel="stylesheet" type="text/css" />
    <link href="../../estilos/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="../../estilos/bi-icons.css" rel="stylesheet" type="text/css" />
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" />

    <!-- JavaScript Files -->
    <script src="../../scripts/jquery.js"></script>
    <script src="../../scripts/mk-auth.js"></script>

    <style>
        :root {
            --primary-color: #0d6cea;
            --secondary-color: #4caf50;
            --danger-color: #f44336;
            --text-color: #333;
            --border-color: #e0e0e0;
            --hover-color: #f5f5f5;
            --success-color: #28a745;
            --warning-color: #da6a28;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: #f8f9fa;
            color: var(--text-color);
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .breadcrumb {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .breadcrumb ul {
            list-style: none;
            display: flex;
            justify-content: center;
            padding: 0;
            margin: 0;
        }

        .breadcrumb li {
            display: flex;
            align-items: center;
        }

        .breadcrumb li:not(:last-child)::after {
            content: "›";
            margin: 0 0.5rem;
            color: var(--text-color);
        }

        .breadcrumb a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .search-container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .search-form {
            display: flex;
            gap: 1rem;
            align-items: flex-end;
        }

        .search-input-group {
            flex: 1;
        }

        .search-input {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid var(--border-color);
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .search-input:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 2px rgba(13, 108, 234, 0.2);
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .btn-search {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-clear {
            background-color: var(--danger-color);
            color: white;
        }

        .table-wrapper {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        th {
            background-color: var(--primary-color);
            color: white !important;
            font-weight: 600;
            padding: 1rem;
            text-align: left;
            position: sticky;
            top: 0;
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }

        tr:hover {
            background-color: var(--hover-color);
        }

        .plan-cell {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .plan-icon {
            width: 24px;
            height: 24px;
            flex-shrink: 0;
        }

        .plan-name {
            color: var(--primary-color);
            font-weight: 600;
            cursor: pointer;
        }
        td .plan-icon, td .value-icon, td .upload-icon, td .download-icon, td .alter-icon {
        width: 20px;
        height: 20px;
        flex-shrink: 0;
        }
        /* Ajuste para os ícones nas células */
        td img {
        margin-right: 5px; /* Espaçamento entre o ícone e o texto */
        vertical-align: middle;
        }
        /* Adiciona espaçamento e alinhamento correto para texto e ícones */
        td span {
        display: inline-block;
        vertical-align: middle;
        }

        .value-cell {
            color: var(--primary-color);
            font-weight: 600;
        }

        .speed-cell {
            color: var(--warning-color);
            font-weight: 600;
        }

        .action-cell a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .action-cell a:hover {
            text-decoration: underline;
        }

        .stats-container {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
        }

        .stats-number {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        @media (max-width: 768px) {
            .search-form {
                flex-direction: column;
                gap: 1rem;
            }
            
            .btn {
                width: 100%;
            }

            .table-wrapper {
                overflow-x: auto;
            }

            th, td {
            padding: 0.5rem;
            text-align: center;
            vertical-align: middle; /* Centraliza o conteúdo verticalmente */
            position: relative;
            }

            .cell-with-icon {
                flex-direction: column;
                align-items: center;
                text-align: center;
                gap: 0.5rem;
            }
			

        }
    </style>

    <script>
        function clearSearch() {
            document.getElementById('search').value = '';
            document.title = 'MK - AUTH';
            document.forms['searchForm'].submit();
        }

        document.addEventListener("DOMContentLoaded", function() {
            var cells = document.querySelectorAll('.plan-name');
            cells.forEach(function(cell) {
                cell.addEventListener('click', function() {
                    var planName = this.innerText;
                    document.getElementById('search').value = planName;
                    document.title = 'Painel: ' + planName;
                    document.forms['searchForm'].submit();
                });
            });
        });
    </script>
</head>

<body>
    <?php include('../../topo.php'); ?>

    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="#">ADDON</a></li>
            <li class="is-active">
                <a href="#" aria-current="page"><?php echo htmlspecialchars($manifestTitle . " - V " . $manifestVersion); ?></a>
            </li>
        </ul>
    </nav>

    <?php include('config.php'); ?>

    <?php if ($acesso_permitido): ?>
        <div class="container">
            <form id="searchForm" method="GET" class="search-container">
                <div class="search-form">
                    <div class="search-input-group">
                        <label for="search" class="font-semibold mb-2 block">Buscar Plano:</label>
                        <input type="text" 
                               id="search" 
                               name="search" 
                               class="search-input"
                               placeholder="Digite o Nome do Plano" 
                               value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    </div>
                    <button type="submit" class="btn btn-search">
                        <i class="fa fa-search"></i> Buscar
                    </button>
                    <button type="button" class="btn btn-clear" onclick="clearSearch()">
                        <i class="fa fa-times"></i> Limpar
                    </button>
                </div>
            </form>

            <?php
                $searchCondition = '';
                $search = '';
                
                if (isset($_GET['search'])) {
                    $search = '%' . mysqli_real_escape_string($link, $_GET['search']) . '%';
                    $searchCondition = " AND (p.nome LIKE ? OR p.valor LIKE ?)";
                }

                $query = "SELECT p.uuid_plano, p.nome, p.valor, p.velup, p.veldown
                          FROM sis_plano p
                          WHERE p.oculto = 'nao'" 
                          . $searchCondition .
                          " ORDER BY p.valor DESC";

                $stmt = mysqli_prepare($link, $query);

                if (!empty($search)) {
                    mysqli_stmt_bind_param($stmt, "ss", $search, $search);
                }

                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $total_planos = mysqli_num_rows($result);
            ?>

            <div class="stats-container">
                <div class="stats-number">
                    <i class="fa fa-list"></i>
                    Total de Planos: <?php echo $total_planos; ?>
                </div>
            </div>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Plano</th>                  
                        <th>Upload</th>
                        <th>Download</th>
                        <th>Valor</th>
                        <th>Alterar Plano</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <!-- Plano -->
                                <td class="cell-with-icon">
                                    <img src="img/plano.png" alt="Ícone de Nome" class="plan-icon">
                                    <span class="plan-name"><?php echo htmlspecialchars($row['nome']); ?></span>
                                </td>
                                
                                <!-- Upload -->
                                <td class="cell-with-icon speed-cell">
                                    <img src="img/upload.png" alt="Ícone de Upload" class="plan-icon">
                                    <span><?php echo htmlspecialchars($row['velup']); ?></span>
                                </td>
                                
                                <!-- Download -->
                                <td class="cell-with-icon speed-cell">
                                    <img src="img/download.png" alt="Ícone de Download" class="plan-icon">
                                    <span><?php echo htmlspecialchars($row['veldown']); ?></span>
                                </td>
                                
                                <!-- Valor -->
                                <td class="cell-with-icon value-cell">
                                    <img src="img/valor.png" alt="Ícone de Valor" class="plan-icon">
                                    <span><?php echo htmlspecialchars($row['valor']); ?></span>
                                </td>
                                
                                <!-- Alterar Plano -->
                                <td class="cell-with-icon action-cell">
                                    <a href="/admin/planos_alt.hhvm?uuid=<?php echo $row['uuid_plano']; ?>">
                                        <img src="img/alterar.png" alt="Ícone de Alterar" class="plan-icon">
                                        Alterar
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    <?php else: ?>
        <div class="container">
            <div class="alert alert-danger">
                Acesso não permitido!
            </div>
        </div>
    <?php endif; ?>

    <?php include('../../baixo.php'); ?>
    <script src="../../menu.js.php"></script>
    <?php include('../../rodape.php'); ?>
</body>
</html>
