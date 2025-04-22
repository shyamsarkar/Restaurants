import {
  IconAperture,
  IconLayoutDashboard,
  IconLogin,
} from "@tabler/icons-react";

import { uniqueId } from "lodash";

const Menuitems = [
  {
    id: uniqueId(),
    title: "Dashboard",
    icon: IconLayoutDashboard,
    href: "/",
  },
  {
    id: uniqueId(),
    title: "Orders",
    icon: IconAperture,
    href: "/orders",
  },
  {
    id: uniqueId(),
    title: "Tables",
    icon: IconAperture,
    href: "/tables",
  },
  {
    id: uniqueId(),
    title: "Menu",
    icon: IconAperture,
    href: "/menu",
  },
  {
    id: uniqueId(),
    title: "Items",
    icon: IconAperture,
    href: "/items",
  },
  {
    id: uniqueId(),
    title: "Units",
    icon: IconAperture,
    href: "/units",
  },
  {
    id: uniqueId(),
    title: "Users",
    icon: IconAperture,
    href: "/users",
  },
];

export default Menuitems;
