<?php
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Exception;

class JWTAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null) {
        
        $keyString = env('JWT_SECRET');
        
        $authHeader = $request->getHeaderLine('Authorization');
        
        // Verifica se o header existe
        if (!$authHeader) {
            return service('response')
                ->setStatusCode(401)
                ->setJSON([
                    'error' => 'Token não fornecido',
                    'message' => 'É necessário enviar o token no header Authorization'
                ]);
        }
        
        // Remove o prefixo "Bearer " do token
        $token = str_replace('Bearer ', '', $authHeader);
        
        try {
            
            $decoded = JWT::decode($token, new Key($keyString, 'HS256'));
            
            log_message('info', 'Token válido! Usuário: ' . json_encode($decoded->data));

            $request->usuarioAutenticado = $decoded->data;
            
            
            return $request;
            
        } catch (ExpiredException $e) {

            return service('response')
                ->setStatusCode(401)
                ->setJSON([
                    'error' => 'Token expirado',
                    'message' => 'Seu token expirou, faça login novamente'
                ]);
                
        } catch (Exception $e) {

            return service('response')
                ->setStatusCode(401)
                ->setJSON([
                    'error' => 'Token inválido',
                    'message' => 'O token fornecido é inválido'
                ]);
        }
    }

    // Não implementado
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
        
    }
}
?>