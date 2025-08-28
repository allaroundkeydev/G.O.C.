import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem, type IvaDeclaracion, type Paginated } from '@/types';
import { Head, Link, router } from '@inertiajs/react';
import { dashboard, ivaDeclaraciones } from '@/routes';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { DotsHorizontalIcon } from '@radix-ui/react-icons';
import { Pagination } from '@/components/pagination';
import { useSearch } from '@/hooks/use-search';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Declaraciones de IVA',
        href: ivaDeclaraciones().index.url,
    },
];

interface Props {
    declaraciones: Paginated<IvaDeclaracion>;
    filters: {
        search: string;
    };
}

export default function IvaDeclaracionesIndex({ declaraciones, filters }: Props) {
    const { search, onSearch } = useSearch(filters.search, ivaDeclaraciones().index.url);

    const deleteDeclaracion = (id: number) => {
        if (confirm('¿Estás seguro de que quieres eliminar esta declaración?')) {
            router.delete(ivaDeclaraciones().destroy.url(id));
        }
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Declaraciones de IVA" />
            <div className="flex flex-col gap-4">
                <div className="flex items-center justify-between">
                    <Input
                        className="max-w-sm"
                        placeholder="Buscar por cliente..."
                        value={search}
                        onChange={onSearch}
                    />
                    <Link href={ivaDeclaraciones().create.url}>
                        <Button>Nueva Declaración</Button>
                    </Link>
                </div>
                <div className="rounded-md border">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Cliente</TableHead>
                                <TableHead>Período</TableHead>
                                <TableHead>Fecha Presentación</TableHead>
                                <TableHead>Monto a Pagar</TableHead>
                                <TableHead className="w-[40px]"></TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {declaraciones.data.map((declaracion) => (
                                <TableRow key={declaracion.id}>
                                    <TableCell>{declaracion.cliente?.nombre}</TableCell>
                                    <TableCell>
                                        {declaracion.periodo_inicio} - {declaracion.periodo_fin}
                                    </TableCell>
                                    <TableCell>{declaracion.fecha_presentacion}</TableCell>
                                    <TableCell>{declaracion.monto_a_pagar}</TableCell>
                                    <TableCell>
                                        <DropdownMenu>
                                            <DropdownMenuTrigger asChild>
                                                <Button variant="ghost" size="icon">
                                                    <DotsHorizontalIcon className="size-4" />
                                                </Button>
                                            </DropdownMenuTrigger>
                                            <DropdownMenuContent align="end">
                                                <Link href={ivaDeclaraciones().show.url(declaracion.id)}>
                                                    <DropdownMenuItem>Ver</DropdownMenuItem>
                                                </Link>
                                                <Link href={ivaDeclaraciones().edit.url(declaracion.id)}>
                                                    <DropdownMenuItem>Editar</DropdownMenuItem>
                                                </Link>
                                                <DropdownMenuItem onClick={() => deleteDeclaracion(declaracion.id)}>
                                                    Eliminar
                                                </DropdownMenuItem>
                                            </DropdownMenuContent>
                                        </DropdownMenu>
                                    </TableCell>
                                </TableRow>
                            ))}
                        </TableBody>
                    </Table>
                </div>
                <Pagination paginated={declaraciones} />
            </div>
        </AppLayout>
    );
}
