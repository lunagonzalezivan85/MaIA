<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CatalogSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        // Catálogo de avatares propios (SVG controlado por el producto)
        if ($this->db->table('agent_avatars')->countAll() === 0) {
            $avatars = [];
            foreach (['atlas', 'bruma', 'cobre', 'delta', 'eco', 'faro'] as $i => $code) {
                $avatars[] = [
                    'code'          => $code,
                    'name'          => ucfirst($code),
                    'resource_path' => "assets/avatars/{$code}.svg",
                    'variants'      => json_encode(['shape' => $i + 1]),
                    'status'        => 'active',
                    'created_at'    => $now,
                ];
            }
            $this->db->table('agent_avatars')->insertBatch($avatars);
        }

        // Plantillas del sistema: Cobro y Promoción (campos propuestos del PRD, DEC-09 pendiente)
        if ($this->db->table('templates')->where('scope', 'system')->countAllResults() === 0) {
            $catalog = [
                [
                    'category'    => 'cobro',
                    'name'        => 'Cobro',
                    'description' => 'Recordar un saldo informado y su vencimiento, sin inventar importes ni realizar cargos.',
                    'fields'      => [
                        ['name' => 'external_id', 'type' => 'string', 'required' => true, 'label' => 'ID de registro'],
                        ['name' => 'cliente', 'type' => 'string', 'required' => true, 'label' => 'Cliente'],
                        ['name' => 'telefono', 'type' => 'phone', 'required' => true, 'label' => 'Teléfono'],
                        ['name' => 'referencia_deuda', 'type' => 'string', 'required' => false, 'label' => 'Referencia de deuda'],
                        ['name' => 'importe', 'type' => 'decimal', 'required' => true, 'label' => 'Importe'],
                        ['name' => 'moneda', 'type' => 'string', 'required' => true, 'label' => 'Moneda'],
                        ['name' => 'vencimiento', 'type' => 'date', 'required' => true, 'label' => 'Vencimiento'],
                    ],
                    'instructions' => 'Recordar el saldo informado y su fecha de vencimiento. No inventar importes ni realizar cargos.',
                    'content'      => 'Estimado/a {cliente}, le recordamos su saldo de {importe} {moneda} con referencia {referencia_deuda}, vencimiento {vencimiento}.',
                ],
                [
                    'category'    => 'promocion',
                    'name'        => 'Promoción',
                    'description' => 'Comunicar la oferta proporcionada a contactos habilitados para ese propósito.',
                    'fields'      => [
                        ['name' => 'external_id', 'type' => 'string', 'required' => true, 'label' => 'ID de registro'],
                        ['name' => 'nombre', 'type' => 'string', 'required' => true, 'label' => 'Nombre'],
                        ['name' => 'telefono', 'type' => 'phone', 'required' => true, 'label' => 'Teléfono'],
                        ['name' => 'promocion', 'type' => 'string', 'required' => true, 'label' => 'Promoción'],
                        ['name' => 'vigencia', 'type' => 'date', 'required' => false, 'label' => 'Vigencia'],
                    ],
                    'instructions' => 'Comunicar la oferta proporcionada únicamente a contactos con permiso para este propósito.',
                    'content'      => 'Hola {nombre}, tenemos una promoción para ti: {promocion}. Vigencia: {vigencia}.',
                ],
            ];

            foreach ($catalog as $tpl) {
                $this->db->table('templates')->insert([
                    'public_id'   => sprintf('tpl_sys_%s', $tpl['category']),
                    'scope'       => 'system',
                    'tenant_id'   => null,
                    'category'    => $tpl['category'],
                    'name'        => $tpl['name'],
                    'description' => $tpl['description'],
                    'status'      => 'published',
                    'created_at'  => $now,
                    'updated_at'  => $now,
                ]);
                $templateId = $this->db->insertID();

                $this->db->table('template_versions')->insert([
                    'template_id'  => $templateId,
                    'version'      => 1,
                    'fields'       => json_encode($tpl['fields']),
                    'instructions' => $tpl['instructions'],
                    'content'      => $tpl['content'],
                    'published_at' => $now,
                    'created_at'   => $now,
                ]);
            }
        }
    }
}
