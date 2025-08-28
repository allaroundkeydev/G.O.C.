import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem, type IvaDeclaracion } from '@/types';
import { Head, Link } from '@inertiajs/react';
import { dashboard, ivaDeclaraciones } from '@/routes';
import { Button } from '@/components/ui/button';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Declaraciones de IVA',
        href: ivaDeclaraciones().index.url,
    },
    {
        title: 'Ver',
        href: '#',
    },
];

interface Props {
    ivaDeclaracion: IvaDeclaracion;
}

export default function IvaDeclaracionShow({ ivaDeclaracion }: Props) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Detalle de la Declaración" />
            <div className="max-w-2xl mx-auto">
                <div className="rounded-md border p-6">
                    <h2 className="text-2xl font-semibold mb-4">Detalle de la Declaración</h2>
                    <div className="space-y-4">
                        <div>
                            <h3 className="text-lg font-medium">Cliente</h3>
                            <p className="text-muted-foreground">{ivaDeclaracion.cliente?.nombre}</p>
                        </div>
                        <div className="grid grid-cols-2 gap-4">
                            <div>
                                <h3 className="text-lg font-medium">Período de Inicio</h3>
                                <p className="text-muted-foreground">{ivaDeclaracion.periodo_inicio}</p>
                            </div>
                            <div>
                                <h3 className="text-lg font-medium">Período de Fin</h3>
                                <p className="text-muted-foreground">{ivaDeclaracion.periodo_fin}</p>
                            </div>
                        </div>
                        <div>
                            <h3 className="text-lg font-medium">Fecha de Presentación</h3>
                            <p className="text-muted-foreground">{ivaDeclaracion.fecha_presentacion}</p>
                        </div>
                        <div>
                            <h3 className="text-lg font-medium">Monto a Pagar</h3>
                            <p className="text-muted-foreground">{ivaDeclaracion.monto_a_pagar}</p>
                        </div>
                        {ivaDeclaracion.plazo && (
                            <>
                                <div>
                                    <h3 className="text-lg font-medium">Cantidad de Cuotas</h3>
                                    <p className="text-muted-foreground">{ivaDeclaracion.cantidad_cuotas}</p>
                                </div>
                                <div>
                                    <h3 className="text-lg font-medium">Día de Pago</h3>
                                    <p className="text-muted-foreground">{ivaDeclaracion.dia_pago}</p>
                                </div>
                            </>
                        )}
                        <div className="flex justify-end">
                            <Link href={ivaDeclaraciones().index.url}>
                                <Button variant="outline">Volver</Button>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
