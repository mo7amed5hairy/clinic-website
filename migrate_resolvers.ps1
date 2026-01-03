$resolvers = Get-ChildItem -Path "c:\laragon\www\clinic-website\app\Modules" -Recurse -Filter "*Resolver.php"

if ($resolvers.Count -eq 0) {
    Write-Host "No resolvers found in Modules."
}

foreach ($file in $resolvers) {
    $content = Get-Content $file.FullName -Raw
    $fileName = $file.Name
    $destination = "c:\laragon\www\clinic-website\app\GraphQL\Resolvers\$fileName"
    
    # Update Namespace
    # Regex to match namespace App\Modules\...\GraphQL or GraphQl;
    $content = $content -replace "namespace App\\Modules\\[^\\]+\\Graph(QL|Ql);", "namespace App\GraphQL\Resolvers;"
    
    # Check if destination exists
    if (Test-Path $destination) {
        Write-Host "Overwriting $destination"
    } else {
        Write-Host "Moving to $destination"
    }
    
    Set-Content -Path $destination -Value $content
    Remove-Item $file.FullName
}

# Update Schema Files
$schemas = Get-ChildItem -Path "c:\laragon\www\clinic-website\graphql" -Recurse -Filter "*.graphql"

foreach ($schema in $schemas) {
    $content = Get-Content $schema.FullName -Raw
    # Regex to replace resolver paths
    # App\Modules\{Module}\GraphQL\{Resolver} -> App\GraphQL\Resolvers\{Resolver}
    # Note: Regex needs double backslashes for literals in the file content
    
    $content = $content -replace 'App\\\\Modules\\\\[^\\\\]+\\\\Graph(QL|Ql)\\\\', 'App\\GraphQL\\Resolvers\\'
    
    Set-Content -Path $schema.FullName -Value $content
    Write-Host "Updated schema: $($schema.Name)"
}
