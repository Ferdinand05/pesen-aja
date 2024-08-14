const Ziggy = {
    url: "http://127.0.0.1:8000",
    port: 8000,
    defaults: {},
    routes: [],
};
if (typeof window !== "undefined" && typeof window.Ziggy !== "undefined") {
    Object.assign(Ziggy.routes, window.Ziggy.routes);
}
export { Ziggy };
