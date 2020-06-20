BEGIN;
INSERT INTO `pedidos`
    (`IdPedido`, `FechaPedido`, `Descuento`, `IdCliente`, `IdLibreria`)
    VALUES  (48, "2019-10-30", 4, 1, 1),
            (49, "2019-10-30", 4, 2, 2),
            (50, "2019-10-30", 4, 3, 3);

INSERT INTO `detallespedidos`
        (`Cantidad`, `ISBN`, `IdPedido`)
        VALUES (10, "1-2345-6789-0", 48),
               (10, "1-2345-6789-0", 49),
               (10, "1-2345-6789-0", 50);
COMMIT;



BEGIN;
INSERT INTO `pedidos`
    (`IdPedido`, `FechaPedido`, `Descuento`, `IdCliente`, `IdLibreria`)
    VALUES  (51, "2019-11-01", 4, 1, 1),
            (52, "2019-11-05", 4, 2, 2),
            (53, "2019-11-06", 4, 3, 3);

INSERT INTO `detallespedidos`
        (`Cantidad`, `ISBN`, `IdPedido`)
        VALUES (10, "1-2345-6789-0", 51),
               (10, "1-2345-6789-0", 52),
               (10, "1-2345-6789-0", 53);
COMMIT;