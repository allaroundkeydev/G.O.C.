import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem, type Cliente } from '@/types';
import { Head } from '@inertiajs/react';
import { dashboard, ivaDeclaraciones } from '@/routes';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import InputError from '@/components/input-error';
import IvaDeclaracionController from '@/actions/App/Http/Controllers/IvaDeclaracionController';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Checkbox } from '@/components/ui/checkbox';
import { LoaderCircle } from 'lucide-react';

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
        title: 'Nueva',
        href: ivaDeclaraciones().create.url,
    },
];

interface Props {
    clientes: Cliente[];
}

export default function IvaDeclaracionCreate({ clientes }: Props) {
    const { data, setData, submit, errors, processing } = IvaDeclaracionController().store();

    const onSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        submit();
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Nueva Declaración de IVA" />
            <div className="max-w-2xl mx-auto">
                <div className="rounded-md border p-6">
                    <h2 className="text-2xl font-semibold mb-4">Nueva Declaración de IVA</h2>
                    <form onSubmit={onSubmit} className="space-y-4">
                        <div>
                            <Label htmlFor="cliente_id">Cliente</Label>
                            <Select
                                value={data.cliente_id.toString()}
                                onValueChange={(value) => setData('cliente_id', parseInt(value))}
                            >
                                <SelectTrigger>
                                    <SelectValue placeholder="Seleccione un cliente" />
                                </SelectTrigger>
                                <SelectContent>
                                    {clientes.map((cliente) => (
                                        <SelectItem key={cliente.id} value={cliente.id.toString()}>
                                            {cliente.nombre}
                                        </SelectItem>
                                    ))}
                                </SelectContent>
                            </Select>
                            <InputError message={errors.cliente_id} />
                        </div>

                        <div className="grid grid-cols-2 gap-4">
                            <div>
                                <Label htmlFor="periodo_inicio">Inicio del Período</Label>
                                <Input
                                    id="periodo_inicio"
                                    type="date"
                                    value={data.periodo_inicio}
                                    onChange={(e) => setData('periodo_inicio', e.target.value)}
                                />
                                <InputError message={errors.periodo_inicio} />
                            </div>
                            <div>
                                <Label htmlFor="periodo_fin">Fin del Período</Label>
                                <Input
                                    id="periodo_fin"
                                    type="date"
                                    value={data.periodo_fin}
                                    onChange={(e) => setData('periodo_fin', e.target.value)}
                                />
                                <InputError message={errors.periodo_fin} />
                            </div>
                        </div>

                        <div>
                            <Label htmlFor="fecha_presentacion">Fecha de Presentación</Label>
                            <Input
                                id="fecha_presentacion"
                                type="date"
                                value={data.fecha_presentacion}
                                onChange={(e) => setData('fecha_presentacion', e.target.value)}
                            />
                            <InputError message={errors.fecha_presentacion} />
                        </div>

                        <div>
                            <Label htmlFor="monto_a_pagar">Monto a Pagar</Label>
                            <Input
                                id="monto_a_pagar"
                                type="number"
                                value={data.monto_a_pagar}
                                onChange={(e) => setData('monto_a_pagar', e.target.value)}
                            />
                            <InputError message={errors.monto_a_pagar} />
                        </div>

                        <div className="flex items-center space-x-2">
                            <Checkbox
                                id="plazo"
                                checked={data.plazo}
                                onCheckedChange={(checked) => setData('plazo', !!checked)}
                            />
                            <Label htmlFor="plazo">¿Aplica plazo?</Label>
                        </div>

                        {data.plazo && (
                            <div className="grid grid-cols-2 gap-4">
                                <div>
                                    <Label htmlFor="cantidad_cuotas">Cantidad de Cuotas</Label>
                                    <Input
                                        id="cantidad_cuotas"
                                        type="number"
                                        value={data.cantidad_cuotas}
                                        onChange={(e) => setData('cantidad_cuotas', parseInt(e.target.value))}
                                    />
                                    <InputError message={errors.cantidad_cuotas} />
                                </div>
                                <div>
                                    <Label htmlFor="dia_pago">Día de Pago</Label>
                                    <Input
                                        id="dia_pago"
                                        type="number"
                                        value={data.dia_pago}
                                        onChange={(e) => setData('dia_pago', e.target.value)}
                                    />
                                    <InputError message={errors.dia_pago} />
                                </div>
                            </div>
                        )}

                        <div className="flex justify-end">
                            <Button type="submit" disabled={processing}>
                                {processing && <LoaderCircle className="mr-2 h-4 w-4 animate-spin" />}
                                Guardar
                            </Button>
                        </div>
                    </form>
                </div>
            </div>
        </AppLayout>
    );
}
